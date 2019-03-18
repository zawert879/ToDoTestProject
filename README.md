# ToDo List

##Авторизация по стандатру oAuth2

логин:
POST /oauth/token
Form Data
client_id: %cliend_id%
grant_type: password
username: %login%
password: %password%
client_secret: %client_secret%

в ответ приходит токен в json
{
"access_token": string,
"expires_in": int(пока 3600 всегда),
"token_type":"bearer", // 
"scope": null, //пока что всегда так
"refresh_token": string
}


сохраняем оба токена и в каждом запросе добавляем заголовок:
Authorization:Bearer %access_token%

проверить, залогинены ли мы можно по адресу:
/api/user/current
или
/api/_profile
в зависимости от проекта



в случае ошибки можно обновить токен через refresh_token

POST /oauth/v2/token
Content-Type:application/x-www-form-urlencoded

Form Data
client_id: %cliend_id%
grant_type: refresh_token
refresh_token: %refresh_token%
client_secret: %client_secret%

ответ идентичен предыдущему случаю
upd:
раньше параметры клиента хардкодились на клиенте.

на новых проектах клиенты будут создаваться при первом заходе с устройства.

при первом заходе необходимо делать запрос
POST api/clients
{
	"allowed_grant_types": array<string>
	"name": string
}

для браузера allowed_grant_types обычно ['password', 'refresh_token']


в ответ приходят параметры нового клиента.
запоминаем, что нам пришло, и в каждый запрос токена подставляем следующие параметры:
clientId = client.id + '_' + client.random_id;
clientSecret = client.secret;

## Firebase

#### deviceId - Уникальное значение на устройстве.

Устройство получает deviceId,которое должен сообщить по запросу
POST  /api/devices
```
{
  "platform": "android"или “ios”,
  "deviceId": "value"
}
```


### Notification

В уведомлениях приходят два значения

notification - уведомление которое приходит от backend и показывается пользователю
	title - заголовок
	body - сообщение

data - уведомление которое приходит от backend и  не показывается пользователю
	внутри могут быть любые поля которые были заданы разработчиком.

