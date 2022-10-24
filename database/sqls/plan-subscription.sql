-- SELECT * FROM sugarc74_sugar_couple.users;

/*

285 - Mardênia - 25
289 - Joelma - 35
312 - Rafaella - 25

*/

SET @userid = 289;
SET @amount = 35;
SET @plan = 'plantium_baby_1';

INSERT INTO `sugarc74_sugar_couple`.`financial_transactions` (`_uid`, `created_at`, `updated_at`, `status`, `amount`, `__data`, `users__id`, `method`, `currency_code`, `is_test`) 
VALUES ( UUID(), '2020-07-20 09:00:00', '2020-07-20 09:00:00', '2', @amount, '{}', @userid, 'PagSeguro', 'BRL', '2');

INSERT INTO `sugarc74_sugar_couple`.`credit_wallet_transactions` (`_uid`, `created_at`, `updated_at`, `status`, `users__id`, `credits`, `financial_transactions__id`, `credit_type`) 
VALUES ( UUID(), '2020-07-20 09:00:00', '2020-07-20 09:00:00', '1', @userid, '0', LAST_INSERT_ID(), '2');

INSERT INTO `sugarc74_sugar_couple`.`user_subscriptions` (`_uid`, `created_at`, `updated_at`, `status`, `users__id`, `expiry_at`, `credit_wallet_transactions__id`, `plan_id`) 
VALUES (UUID(), '2020-07-20 09:00:00', '2020-07-20 09:00:00', '1', @userid, '2020-08-20 09:00:00', LAST_INSERT_ID(), @plan);


