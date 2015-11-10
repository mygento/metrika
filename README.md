<h2>Интеграция Яндекс.Метрики в Magento</h2>
[![Build Status](https://travis-ci.org/mygento/metrika.svg?branch=master)](https://travis-ci.org/mygento/metrika)[![Code Climate](https://codeclimate.com/github/mygento/metrika/badges/gpa.svg)](https://codeclimate.com/github/mygento/metrika)
<p>Модуль позволяет быстро и просто интегрировать счетчик метрики для интернет-магазина на Magento:</p>
<ul>
<li>Интеграция кода счетчика в конец страницы (before_body_end)</li>
<li>Отчет «Параметры интернет-магазинов» http://help.yandex.ru/metrika/content/e-commerce.xml<br/>
Для его настройки, нужно зайти в настройки счетчика, в секцию "Цели", и добавить две цели:<br/>
1)<b>Название:</b> Корзина, <b>Собирать подробную статистику</b> - Да, <b>Условия: URL страницы</b>, url: содержит -> checkout/cart/, <b>Типы целей интернет-магазинов</b> - Да, эта цель описывает корзину на моём сайте<br/>
2)<b>Название:</b> Заказ, <b>Собирать подробную статистику</b> - Да, <b>Условия: URL страницы</b>, url: содержит -> checkout/onepage/success, <b>Типы целей интернет-магазинов</b> - Да, эта цель описывает подтверждение заказа на моём сайте<br/>
</li>
</ul>

<h2>Yandex Metrica Magento intergration extension</h2>
<p>Simple and quick counter integration for Magento e-commerce store.</p>
<ul>
<li>Counter integration to end of all pages (before_body_end section)</li>
<li>«Online store parameters» report http://help.yandex.com/metrica/content/e-commerce.xml</li>
</ul>

=======
www.mygento.ru
