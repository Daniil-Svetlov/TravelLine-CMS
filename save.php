<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jsonFile = 'data.json';
    $data = [];
    if (file_exists($jsonFile)) {
        $data = json_decode(file_get_contents($jsonFile), true) ?? [];
    }
    $type = $_POST['type'] ?? '';

    switch ($type) {
        case 'hero_update':
            $data['hero']['title'] = $_POST['hero_title'] ?? '';
            $data['hero']['subtitle'] = $_POST['hero_subtitle'] ?? '';
            break;

        case 'team_add':
            if (!isset($data['team']) || !is_array($data['team'])) $data['team'] = [];
            $data['team'][] = [
                'name' => $_POST['name'] ?? '',
                'position' => $_POST['position'] ?? '',
                'photo' => $_POST['photo'] ?? 'assets/images/default.jpg'
            ];
            break;

        case 'team_delete':
            $idx = $_POST['index'] ?? null;
            if ($idx !== null && isset($data['team'][$idx])) {
                unset($data['team'][$idx]);
                $data['team'] = array_values($data['team']);
            }
            break;

        case 'vacancy_add':
            if (!isset($data['vacancies']) || !is_array($data['vacancies'])) $data['vacancies'] = [];
            $data['vacancies'][] = [
                'title' => $_POST['title'] ?? '',
                'format' => $_POST['format'] ?? '',
                'url' => $_POST['url'] ?? ''
            ];
            break;

        case 'vacancy_delete':
            $idx = $_POST['index'] ?? null;
            if ($idx !== null && isset($data['vacancies'][$idx])) {
                unset($data['vacancies'][$idx]);
                $data['vacancies'] = array_values($data['vacancies']);
            }
            break;

        case 'direction_add':
            if (!isset($data['directions']) || !is_array($data['directions'])) {
                $data['directions'] = [];
            }
            $data['directions'][] = [
                'name' => $_POST['dir_name'] ?? '',
                'description' => $_POST['dir_desc'] ?? '',
                'technologies' => [] 
            ];
            break;

        case 'direction_delete':
            $dirIdx = $_POST['dir_index'] ?? null;
            if ($dirIdx !== null && isset($data['directions'][$dirIdx])) {
                unset($data['directions'][$dirIdx]);
                $data['directions'] = array_values($data['directions']);
            }
            break;

        case 'tech_add':
            $dirIdx = $_POST['dir_index'] ?? null;
            if ($dirIdx !== null && isset($data['directions'][$dirIdx])) {
                if (!isset($data['directions'][$dirIdx]['technologies']) || !is_array($data['directions'][$dirIdx]['technologies'])) {
                    $data['directions'][$dirIdx]['technologies'] = [];
                }
                $data['directions'][$dirIdx]['technologies'][] = [
                    'name' => $_POST['tech_name'] ?? '',
                    'icon' => $_POST['tech_icon'] ?? ''
                ];
            }
            break;

        case 'tech_delete':
            $dirIdx = $_POST['dir_index'] ?? null;
            $techIdx = $_POST['tech_index'] ?? null;
            if ($dirIdx !== null && $techIdx !== null && isset($data['directions'][$dirIdx]['technologies'][$techIdx])) {
                unset($data['directions'][$dirIdx]['technologies'][$techIdx]);
                $data['directions'][$dirIdx]['technologies'] = array_values($data['directions'][$dirIdx]['technologies']);
            }
            break;
        case 'bonus_add':
            if (!isset($data['bonuses']) || !is_array($data['bonuses'])) {
                $data['bonuses'] = [];
            }
            $data['bonuses'][] = [
                'title' => trim($_POST['title'] ?? ''),
                'text' => trim($_POST['text'] ?? '')
            ];
            break;

        case 'bonus_delete':
            $idx = $_POST['index'] ?? null;
            if ($idx !== null && isset($data['bonuses'][$idx])) {
                unset($data['bonuses'][$idx]);
                $data['bonuses'] = array_values($data['bonuses']);
            }
            break;
    }
    file_put_contents($jsonFile, json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    header('Location: admin.php');
    exit;
}
?>