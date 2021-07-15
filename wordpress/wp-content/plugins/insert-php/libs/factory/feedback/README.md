# Установка

Добавить в главный файл плагина в раздел Отладочных констант

```php
 //Включить режим отладки для модуля обратной связи. Если FACTORY_FEEDBACK_DEBUG true,
 //то модуль обратной связи не будет отправлять данные о деактивации плагина
 if ( ! defined( 'FACTORY_FEEDBACK_DEBUG' ) ) {
 	define( 'FACTORY_FEEDBACK_DEBUG', true );
 }
 
 //Остановить показ окна фидбэка для всех плагинов созданных на Factory фреймворке.
 //Это может пригодиться, если есть проблемы с деактивацией плагина.
 if ( ! defined( 'FACTORY_FEEDBACK_BLOCK' ) ) {
 	define( 'FACTORY_FEEDBACK_BLOCK', false );
 }
 ```
 
Добавить в раздел подключения модулей

```php
array( 'libs/factory/feedback', 'factory_feedback_000', 'admin'), // Модуль для запроса обратной связи от пользователя
```