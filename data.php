<?php
require_once 'utils/loadEnv.php';
loadEnv('./.env');

const DB_PATH = __DIR__ . '/db/db.sqlite';
define('EVENT_TITLE', $_ENV['EVENT_TITLE'] ?? 'Invitación al evento');
define('EVENT_SUBTITLE', $_ENV['EVENT_SUBTITLE'] ?? 'Te han invitado a un evento');
define('EVENT_DESCRIPTION', $_ENV['EVENT_DESCRIPTION'] ?? 'Información del evento');
define('EVENT_DAY', $_ENV['EVENT_DAY'] ?? '2025-12-12');
define('EVENT_START', $_ENV['EVENT_START'] ?? '2025-12-12 00:00:00');
define('EVENT_END', $_ENV['EVENT_END'] ?? '2025-12-12 00:00:00');
define('EVENT_LOCATION', $_ENV['EVENT_LOCATION'] ?? '');
define('EVENT_URL_MAP', $_ENV['EVENT_URL_MAP'] ?? '');

define('ADMIN_PASSWORD', $_ENV['ADMIN_PASSWORD'] ?? '');