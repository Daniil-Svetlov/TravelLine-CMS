<?php
$databaseFile = __DIR__ . '/data.json';
$data = [];

if (file_exists($databaseFile)) {
    $data = json_decode(file_get_contents($databaseFile), true) ?? [];
}

// Дефолтные значения для Hero, если JSON пустой
$heroTitle = $data['hero']['title'] ?? 'Стабильно растем';
$heroSubtitle = $data['hero']['subtitle'] ?? 'Разрабатываем решения для бизнеса';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Панель управления TravelLine Tech</title>
    <style>
        :root {
            --primary: #2b4cc0;
            --primary-light: #4769e6;
            --bg-gradient: linear-gradient(135deg, #eef2f7 0%, #dbe5f7 50%, #e3edff 100%);
            --glass-bg: rgba(255, 255, 255, 0.45);
            --glass-border: rgba(255, 255, 255, 0.6);
            --glass-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.08);
            --text-main: #2c3a61;
            --text-muted: #5c6b94;
            --card-inner: rgba(255, 255, 255, 0.7);
        }

        body { 
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; 
            background: var(--bg-gradient); 
            background-attachment: fixed;
            margin: 0; 
            padding: 40px 20px; 
            color: var(--text-main);
            min-height: 100vh;
        }

        .container { 
            max-width: 900px; 
            margin: 0 auto; 
            background: var(--glass-bg); 
            backdrop-filter: blur(16px); 
            -webkit-backdrop-filter: blur(16px);
            padding: 40px; 
            border-radius: 24px; 
            border: 1px solid var(--glass-border);
            box-shadow: var(--glass-shadow);
        }

        h1 { 
            color: var(--primary); 
            font-size: 28px;
            margin-top: 0;
            font-weight: 800;
            letter-spacing: -0.5px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .link-main {
            font-size: 14px;
            color: var(--primary);
            text-decoration: none;
            padding: 8px 16px;
            background: var(--card-inner);
            border-radius: 12px;
            border: 1px solid var(--glass-border);
            transition: all 0.2s ease;
        }
        .link-main:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-2px);
        }

        h2 { 
            color: var(--primary); 
            margin-top: 40px; 
            font-size: 20px; 
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        h3 { font-size: 15px; color: var(--text-muted); margin-bottom: 10px; }
        
        form { 
            display: flex; 
            flex-direction: column; 
            gap: 16px; 
            background: var(--card-inner); 
            padding: 20px; 
            border-radius: 16px; 
            border: 1px solid var(--glass-border);
            box-shadow: 0 4px 12px rgba(0,0,0,0.02);
            transition: transform 0.3s ease;
        }
        form:focus-within {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(43, 76, 192, 0.05);
        }

        label { font-weight: 600; font-size: 13px; color: var(--text-main); }
        
        input[type="text"], input[type="url"], textarea { 
            width: 100%; 
            padding: 12px 16px; 
            background: rgba(255, 255, 255, 0.8);
            border: 1px solid rgba(43, 76, 192, 0.15); 
            border-radius: 12px; 
            box-sizing: border-box; 
            font-size: 14px;
            color: var(--text-main);
            transition: all 0.2s ease;
        }
        input[type="text"]:focus, input[type="url"]:focus, textarea:focus { 
            outline: none;
            border-color: var(--primary);
            background: #fff;
            box-shadow: 0 0 0 3px rgba(43, 76, 192, 0.1);
        }

        textarea { font-family: inherit; resize: vertical; }
        
        button { 
            background: var(--primary); 
            color: white; 
            border: 0; 
            padding: 12px 20px; 
            border-radius: 12px; 
            cursor: pointer; 
            font-weight: 600; 
            font-size: 14px;
            transition: all 0.2s ease; 
            align-self: flex-start;
        }
        button:hover { 
            background: var(--primary-light); 
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(43, 76, 192, 0.2);
        }
        
        .item-list { display: flex; flex-direction: column; gap: 12px; margin-top: 15px; }
        
        .item-card { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            padding: 16px; 
            border: 1px solid var(--glass-border); 
            border-radius: 14px; 
            background: rgba(255, 255, 255, 0.6); 
            backdrop-filter: blur(4px);
            box-shadow: 0 2px 6px rgba(0,0,0,0.01);
        }

        .btn-delete { 
            background: rgba(217, 83, 79, 0.1); 
            padding: 8px 14px; 
            font-size: 12px; 
            color: #d9534f; 
            border: 1px solid rgba(217, 83, 79, 0.2);
            border-radius: 10px; 
            cursor: pointer; 
            font-weight: 600;
        }
        .btn-delete:hover { 
            background: #d9534f; 
            color: white;
            box-shadow: 0 4px 10px rgba(217, 83, 79, 0.15);
        }
        
        hr { margin: 40px 0; border: 0; border-top: 1px dashed rgba(43, 76, 192, 0.2); }

        .tech-badge {
            display: inline-flex; 
            align-items: center; 
            background: rgba(255,255,255,0.8); 
            padding: 6px 12px; 
            border-radius: 10px; 
            font-size: 13px; 
            gap: 8px;
            border: 1px solid var(--glass-border);
            box-shadow: 0 2px 4px rgba(0,0,0,0.02);
        }
    </style>
</head>
<body>

<div class="container">
    <h1>
        <span>Панель управления TravelLine Tech</span>
        <a href="index.php" target="_blank" class="link-main">На главную &rarr;</a>
    </h1>

    <h2>1. Блок «Hero» (Главный экран)</h2>
    <form action="save.php" method="POST">
        <input type="hidden" name="type" value="hero_update">
        <div>
            <label>Главный заголовок страницы:</label>
            <input type="text" name="hero_title" value="<?php echo htmlspecialchars($heroTitle); ?>" required>
        </div>
        <div>
            <label>Подзаголовок:</label>
            <input type="text" name="hero_subtitle" value="<?php echo htmlspecialchars($heroSubtitle); ?>" required>
        </div>
        <button type="submit">Обновить главный экран</button>
    </form>

    <hr>

    <h2>2. Блок «Команда» (Слайдер сотрудников)</h2>
    <form action="save.php" method="POST">
        <input type="hidden" name="type" value="team_add">
        <div>
            <label>Имя сотрудника:</label>
            <input type="text" name="name" placeholder="Например: Иван Иванов" required>
        </div>
        <div>
            <label>Должность:</label>
            <input type="text" name="position" placeholder="Например: Frontend-разработчик" required>
        </div>
        <div>
            <label>Путь к фото:</label>
            <input type="text" name="photo" value="assets/images/default.jpg" required>
        </div>
        <button type="submit">Добавить сотрудника в команду</button>
    </form>

    <h3>Текущий состав команды:</h3>
    <div class="item-list">
        <?php if (isset($data['team']) && !empty($data['team'])) { ?>
            <?php foreach ($data['team'] as $index => $employee) { ?>
                <div class="item-card">
                    <div>
                        <strong style="color: var(--text-main);"><?php echo htmlspecialchars($employee['name']); ?></strong> 
                        <span style="color: var(--text-muted);"> — <?php echo htmlspecialchars($employee['position']); ?></span>
                    </div>
                    <form action="save.php" method="POST" style="padding:0; border:0; background:none; box-shadow:none;">
                        <input type="hidden" name="type" value="team_delete">
                        <input type="hidden" name="index" value="<?php echo $index; ?>">
                        <button type="submit" class="btn-delete">Удалить</button>
                    </form>
                </div>
            <?php } ?>
        <?php } else { ?>
            <p style="color: var(--text-muted); font-size: 14px;">Список пуст.</p>
        <?php } ?>
    </div>

    <hr>

    <h2>3. Блок «Вакансии»</h2>
    <form action="save.php" method="POST">
        <input type="hidden" name="type" value="vacancy_add">
        <div>
            <label>Название вакансии:</label>
            <input type="text" name="title" placeholder="Например: QA Automation Engineer" required>
        </div>
        <div>
            <label>Формат работы:</label>
            <input type="text" name="format" placeholder="Например: удаленно / офис Йошкар-Ола" required>
        </div>
        <div>
            <label>Ссылка на вакансию (hh.ru):</label>
            <input type="url" name="url" placeholder="https://hh.ru/vacancy/..." required>
        </div>
        <button type="submit">Добавить вакансию</button>
    </form>

    <h3>Доступные вакансии:</h3>
    <div class="item-list">
        <?php if (isset($data['vacancies']) && !empty($data['vacancies'])) { ?>
            <?php foreach ($data['vacancies'] as $index => $v) { ?>
                <div class="item-card">
                    <div>
                        <strong><?php echo htmlspecialchars($v['title']); ?></strong> 
                        <span style="color: var(--text-muted);"> (<?php echo htmlspecialchars($v['format']); ?>)</span>
                    </div>
                    <form action="save.php" method="POST" style="padding:0; border:0; background:none; box-shadow:none;">
                        <input type="hidden" name="type" value="vacancy_delete">
                        <input type="hidden" name="index" value="<?php echo $index; ?>">
                        <button type="submit" class="btn-delete">Удалить</button>
                    </form>
                </div>
            <?php } ?>
        <?php } else { ?>
            <p style="color: var(--text-muted); font-size: 14px;">Вакансий нет.</p>
        <?php } ?>
    </div>

    <hr>

    <h2>4. Блок «Направления» (Backend, Frontend и др.)</h2>
    <form action="save.php" method="POST" style="margin-bottom: 30px;">
        <input type="hidden" name="type" value="direction_add">
        <h3 style="margin-top:0;">Создать новое направление</h3>
        <div>
            <label>Название направления:</label>
            <input type="text" name="dir_name" placeholder="Например: Backend, Frontend, QA" required>
        </div>
        <div>
            <label>Описание:</label>
            <input type="text" name="dir_desc" placeholder="Краткое описание того, чем занимается команда" required>
        </div>
        <button type="submit">Создать направление</button>
    </form>

    <h3>Текущие направления и их технологии:</h3>
    <div style="display: flex; flex-direction: column; gap: 20px; margin-bottom: 30px;">
        <?php if (isset($data['directions']) && !empty($data['directions'])) { ?>
            <?php foreach ($data['directions'] as $dirIndex => $dir) { ?>
                <div style="background: rgba(255, 255, 255, 0.5); border: 1px solid var(--glass-border); padding: 24px; border-radius: 18px; position: relative; box-shadow: 0 4px 12px rgba(0,0,0,0.01);">
                    
                    <form action="save.php" method="POST" style="position: absolute; top: 20px; right: 20px; padding:0; border:0; background:none; box-shadow:none;">
                        <input type="hidden" name="type" value="direction_delete">
                        <input type="hidden" name="dir_index" value="<?php echo $dirIndex; ?>">
                        <button type="submit" class="btn-delete" style="padding: 6px 12px;">Удалить направление</button>
                    </form>

                    <h3 style="margin: 0 0 8px 0; color: var(--primary); font-size: 18px; font-weight: 700;"><?php echo htmlspecialchars($dir['name']); ?></h3>
                    <p style="margin: 0 0 20px 0; font-size: 14px; color: var(--text-muted); max-width: 75%; line-height: 1.5;">
                        <?php 
                            $dirDescription = $dir['description'] ?? $dir['desc'] ?? '';
                            echo htmlspecialchars($dirDescription); 
                        ?>
                    </p>

                    <h4 style="margin: 10px 0 8px 0; font-size:13px; font-weight:600; text-transform: uppercase; letter-spacing: 0.5px; color: var(--text-muted);">Технологии:</h4>
                    <div style="display:flex; flex-wrap:wrap; gap: 10px; margin-bottom: 20px;">
                        <?php if (isset($dir['technologies']) && !empty($dir['technologies'])) { ?>
                            <?php foreach ($dir['technologies'] as $techIndex => $tech) { ?>
                                <span class="tech-badge">
                                    <?php if(!empty($tech['icon'])) { ?>
                                        <img src="<?php echo htmlspecialchars($tech['icon']); ?>" width="16" height="16" alt="">
                                    <?php } ?>
                                    <strong style="font-weight: 600;"><?php echo htmlspecialchars($tech['name']); ?></strong>
                                    
                                    <form action="save.php" method="POST" style="display:inline; padding:0; border:0; background:none; box-shadow:none;">
                                        <input type="hidden" name="type" value="tech_delete">
                                        <input type="hidden" name="dir_index" value="<?php echo $dirIndex; ?>">
                                        <input type="hidden" name="tech_index" value="<?php echo $techIndex; ?>">
                                        <button type="submit" style="background:none; color:#d9534f; padding:0; border:0; cursor:pointer; font-weight:bold; margin-left:5px; font-size:16px; line-height:1;">&times;</button>
                                    </form>
                                </span>
                            <?php } ?>
                        <?php } else { ?>
                            <span style="color:var(--text-muted); font-size:13px; font-style: italic;">Технологий пока нет</span>
                        <?php } ?>
                    </div>

                    <form action="save.php" method="POST" style="background: rgba(43, 76, 192, 0.04); padding:16px; border-radius:12px; display:flex; flex-direction:row; gap:12px; align-items:flex-end; border: 1px solid rgba(43, 76, 192, 0.05); box-shadow:none;">
                        <input type="hidden" name="type" value="tech_add">
                        <input type="hidden" name="dir_index" value="<?php echo $dirIndex; ?>">
                        <div style="flex:1;">
                            <label style="font-size:11px; display:block; margin-bottom:4px;">Название технологии:</label>
                            <input type="text" name="tech_name" placeholder="Например: PHP" required style="padding:8px 12px; font-size:13px;">
                        </div>
                        <div style="flex:1;">
                            <label style="font-size:11px; display:block; margin-bottom:4px;">Путь к иконке:</label>
                            <input type="text" name="tech_icon" value="assets/images/icons/" required style="padding:8px 12px; font-size:13px;">
                        </div>
                        <button type="submit" style="padding: 0; width:34px; height:34px; min-width:34px; display:flex; align-items:center; justify-content:center; font-size:18px; border-radius:10px; background: var(--primary);">&plus;</button>
                    </form>

                </div>
            <?php } ?>
        <?php } else { ?>
            <p style="color: var(--text-muted); font-size: 14px;">Направлений пока нет.</p>
        <?php } ?>
    </div>

    <hr>

    <h2>5. Блок «Плюшки и все такое» (Бонусы)</h2>
    <form action="save.php" method="POST">
        <input type="hidden" name="type" value="bonus_add">
        <div>
            <label>Заголовок бонуса:</label>
            <input type="text" name="title" placeholder="Например: Онбординг в компанию" required>
        </div>
        <div>
            <label>Описание бенефита:</label>
            <textarea name="text" rows="3" placeholder="Например: Наставник поможет быстро включиться в работу." required></textarea>
        </div>
        <button type="submit">Добавить бонус</button>
    </form>

    <h3>Текущие бонусы (Плюшки):</h3>
    <div class="item-list">
        <?php if (isset($data['bonuses']) && !empty($data['bonuses'])) { ?>
            <?php foreach ($data['bonuses'] as $index => $b) { ?>
                <div class="item-card">
                    <div style="max-width: 80%;">
                        <strong style="color: var(--text-main); font-size: 15px;"><?php echo htmlspecialchars($b['title']); ?></strong>
                        <p style="margin: 6px 0 0 0; font-size: 13px; color: var(--text-muted); line-height: 1.4;"><?php echo htmlspecialchars($b['text']); ?></p>
                    </div>
                    <form action="save.php" method="POST" style="padding:0; border:0; background:none; box-shadow:none;">
                        <input type="hidden" name="type" value="bonus_delete">
                        <input type="hidden" name="index" value="<?php echo $index; ?>">
                        <button type="submit" class="btn-delete">Удалить</button>
                    </form>
                </div>
            <?php } ?>
        <?php } else { ?>
            <p style="color: var(--text-muted); font-size: 14px;">Бонусы еще не добавлены.</p>
        <?php } ?>
    </div>

</div>

</body>
</html>