<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use Auth;

class SessionTimeout
{
  public function handle($request, Closure $next)
  {
    // If user is not logged in...
    if (!Auth::check()) {
      return $next($request);
    }

    $user = Auth::guard()->user();

    if(isAdmin()){
      return $next($request);
    }

    if(isPremiumUser()){
      return $next($request);
    }

    if(!isProfileComplete($user->_id)){
      return $next($request);
    }

    $now = Carbon::now();

    if(__isEmpty($user->last_seen_at)){
      $user->last_seen_at = $now->format('Y-m-d H:i:s');
      $user->save();
    }

    $last_seen = Carbon::parse($user->last_seen_at);

    if(!$last_seen->isToday()){
      $user->last_seen_at = $now->format('Y-m-d H:i:s');
      $user->save();
      $last_seen = Carbon::parse($user->last_seen_at);
    }

    $session_time = $now->diffInMinutes($last_seen);

    
    $allowedRouteList = [
      'user.profile_view',
      'user.premium_plan.read.view',
      'user.premium_plan.write.buy_premium_plan',
      'user.premium_plan.read.success_view',
      'user.update_profile.wizard',
      'user.write.update_profile_wizard',
      'user.write.location_data',
      'user.upload_profile_image',
      'user.upload_cover_image',
      'user.upload_photos',
      'user.photos_setting',
      'user.upload_photos.write.delete',

      'user.profile.wizard_completed',
      'user.credit_wallet.write.paypal_transaction_complete',
      'user.credit_wallet.write.paypal_plan_transaction_complete',
      'user.credit_wallet.write.pagseguro_plan_transaction_complete',
      'user.credit_wallet.write.payment_process',
      'api.user.credit_wallet.apply.payment_cupom',
      'pagseguro.checkout',

      'manage.user.write.photo_delete',
      'manage.user.edit',
      'manage.user.write.update',
      'user.write.basic_setting',
      'user.write.profile_setting',
      'user.get_profile_data',
      'user.logout',
      'blurred.images',
      'user.notification.write.read_all_notification',
      
      'landing_page',
      'plans',
      'terms',
      'policy',



          ];

    $allowedRoute = false;

    foreach($allowedRouteList as $route){
      if($route == $request->route()->getName()){
        $allowedRoute = true;
      }
    }

    // If user has been inactivity longer than the allowed inactivity period
    if ($last_seen->isToday() && $session_time >= getFreeUserMaxSessionTime() && $allowedRoute == false) {
      //Auth::guard()->logout();
      //$request->session()->invalidate();
      return redirect()->route('user.profile_view', ['username' => $user->username]);
    }

    // $user->last_seen_at = $now->format('Y-m-d H:i:s');
    // $user->save();

    return $next($request);
  }
}