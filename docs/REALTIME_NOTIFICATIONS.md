# Notificaciones en tiempo real

Backend separado para web y móvil:

- **Web (worker)**: Laravel Echo + Pusher en canal privado `user.{id}` con evento `.notification.created`; mantiene `wire:poll` como respaldo.
- **Móvil (Flutter)**: puedes usar _polling incremental_ vía `/api/my-notifications` (ya listo) o _tiempo real_ suscribiéndote al canal `private-user.{id}` y evento `notification.created` (requiere Pusher/Ably/WebSockets configurado).

## Backend ya implementado

- **API móvil (auth:sanctum, role:worker)**
  - `GET /api/my-notifications?unread_only=1&since=2025-11-22T00:00:00Z&per_page=20`
  - `POST /api/my-notifications/read` con body `{ "ids": [1,2,3] }`
- **Web worker**: la vista `resources/views/livewire/worker/notificaciones.blade.php` escucha Echo/Pusher y también hace `wire:poll.10s` como respaldo.

## Flutter: polling incremental (simple)
1) Autentica y guarda el token Sanctum.
2) Servicio de notificaciones:
```dart
class NotificationService {
  final String baseUrl;
  final String token;
  DateTime? lastSync;

  NotificationService({required this.baseUrl, required this.token});

  Future<List<Map<String, dynamic>>> fetch({bool unreadOnly = false}) async {
    final params = {
      if (unreadOnly) 'unread_only': '1',
      if (lastSync != null) 'since': lastSync!.toUtc().toIso8601String(),
      'per_page': '50',
    };
    final uri = Uri.parse('$baseUrl/api/my-notifications').replace(queryParameters: params);
    final resp = await http.get(uri, headers: {
      'Authorization': 'Bearer $token',
      'Accept': 'application/json',
    });
    if (resp.statusCode != 200) throw Exception('Error ${resp.statusCode}: ${resp.body}');
    final body = jsonDecode(resp.body) as Map<String, dynamic>;
    final data = (body['data']['data'] as List).cast<Map<String, dynamic>>();
    if (data.isNotEmpty) lastSync = DateTime.parse(data.first['created_at'] as String);
    return data;
  }

  Future<void> markRead(List<int> ids) async {
    final resp = await http.post(
      Uri.parse('$baseUrl/api/my-notifications/read'),
      headers: {
        'Authorization': 'Bearer $token',
        'Accept': 'application/json',
        'Content-Type': 'application/json',
      },
      body: jsonEncode({'ids': ids}),
    );
    if (resp.statusCode != 200) throw Exception('Error marcando leídas');
  }
}
```
3) Usa `Timer.periodic(const Duration(seconds: 8), (_) => fetch())` y muestra un snack/local notification al recibir nuevas.

## Flutter: tiempo real con websockets (Pusher)
1) Configura el broadcaster en `.env` (ver abajo) y publica credenciales.
2) Instala `pusher_channels_flutter`.
3) Suscríbete a `private-user.<user_id>` y escucha `notification.created`:
```dart
final pusher = PusherChannelsFlutter.getInstance();
await pusher.init(
  apiKey: 'PUSHER_APP_KEY',
  cluster: 'PUSHER_APP_CLUSTER',
  onEvent: (event) {
    if (event.eventName == 'notification.created') {
      final data = jsonDecode(event.data!);
      // data: {id,title,message,type,request_id,created_at}
      // Actualiza estado UI o muestra notificación local.
    }
  },
  authEndpoint: '$baseUrl/broadcasting/auth',
  onAuthorizer: (channelName, socketId, options) async {
    final resp = await http.post(
      Uri.parse('$baseUrl/broadcasting/auth'),
      headers: {
        'Authorization': 'Bearer $token',
        'Content-Type': 'application/json',
      },
      body: jsonEncode({'socket_id': socketId, 'channel_name': channelName}),
    );
    return jsonDecode(resp.body);
  },
);
await pusher.subscribe(channelName: 'private-user.$userId');
await pusher.connect();
```
4) Mantén el polling como respaldo si quieres tolerancia a desconexiones.

## Pasos para habilitar Pusher/Ably/WebSockets
1) `.env`:
   ```
   BROADCAST_DRIVER=pusher
   PUSHER_APP_ID=xxx
   PUSHER_APP_KEY=xxx
   PUSHER_APP_SECRET=xxx
   PUSHER_APP_CLUSTER=mt1
   ```
2) Evento creado: `App\Events\NotificationCreated implements ShouldBroadcastNow`, canal privado `user.{id}`, nombre `.notification.created`.
3) Livewire (secretaría) emite el evento al crear la notificación. Web worker ya escucha el canal; Flutter debe suscribirse como arriba.
