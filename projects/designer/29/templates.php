<?php function changelog_template($cmp){?>
<? $cmp->drawSection(0) ?>
<?php }//changelog_template?>
<?php function jq1_0a3_template($cmp){?>
<h1>Jquicks 1.0a3</h1>
<ul>
<li>Добавлен функционал для вставки в страницу компонента, использующегося на других страницах</li>
<li>Добавлена функция TComponent::CreateModel для создания внедрённых моделей. Внедрённые модели теперь должны создавться методом CreateModels. Под донную технологию доработаны все компоненты.</li>
</ul>
<?php }//jq1_0a3_template?>
<?php function jq1_0a4_template($cmp){?>
<h1>Jquicks 1.0a4</h1>
<ul>
<li><h2>Ядро</h2>
<ul>
<li>Код разбит на модули в соответствии с <a href="https://docs.google.com/document/d/1zTGoDnrL1CCSiWTjvxfc33_9j72OC2HOugsB2HvRIvk/edit">концепцией модульной структуры</a></li>
<li>В TPageEditService добавлена модель files (не отлажена!)</li>
<li>Реализована <a href="https://docs.google.com/document/d/1G8Dt0oeGXOu8HugVUfl3iXpT-QT9DYcnAKJnkDfAkF4/edit">концепция компиляции файлов описаний служб</a></li>
<li>Классы компонентов разделены на основной и "<a href="https://docs.google.com/document/d/18lM5JmHITv3BB3vtNeetE40OO0_Feb1TFjcxtPGAmiA/edit">дизайнер-класс</a>"</li>
<li>В <a href="https://docs.google.com/document/d/1a1pWlQb9nO26LcDhj_aFwx4LEzRtsh8j1GQXoW3Zq-M/edit">шаблоны</a> добавлены функции "ifNull" и "isKeyExist"</li>
<li>Реализована <a href="https://docs.google.com/document/d/1Lez7yoO52RNcO7bY3OOFv0uumsvs21Zhx5uUZfGz0R4/edit">концепция внешних ссылок</a></li>
<li>Описание структур таблиц базы данных перенесено из кода класса в service.xml</li>
<li>Реализовано приведение полей модели типа integer к типу integer при извлечении их из таблиц базы данных (из базы MySQL они выбираются как string)</li>
</ul>
</li>
<li><h2>Дизайнер</h2>
<ul>
<li>Реализовано обновление дерева при переходе по ссылкам на редактируемых страницах</li>
<li>Добавлен редактор полей типа "link"</li>
<li>Редактор текстовых полей реализован как отдельный компонент</li>
</ul>
</li>
<li><h2>Компоненты</h2>
</li>
<ul>
<li>Добавлен компонент TTextSpeedEditor</li>
<li>Добавлен компонент TLinkSpeedEditor</li>
<li>Добавлен компонент TForumService</li>
<li>Обновлён компонент TServiceControlled с целью поддержки внешних ссылок</li>
</ul>
</ul>
<?php }//jq1_0a4_template?>