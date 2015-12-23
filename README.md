### Интеграция Яндекс.Метрики в Magento
[![Build Status](https://travis-ci.org/mygento/metrika.svg?branch=1.0)](https://travis-ci.org/mygento/metrika)[![Code Climate](https://codeclimate.com/github/mygento/metrika/badges/gpa.svg)](https://codeclimate.com/github/mygento/metrika)[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/mygento/metrika/badges/quality-score.png?b=1.0)](https://scrutinizer-ci.com/g/mygento/metrika/?branch=1.0)

Модуль позволяет быстро и просто интегрировать счетчик метрики для интернет-магазина на Magento:
* Интеграция кода счетчика в начало страницы (after_body_start)
* Отчет «Параметры интернет-магазинов» http://help.yandex.ru/metrika/content/e-commerce.xml  

Для его настройки, нужно зайти в настройки счетчика, в секцию "Цели", и добавить две цели:
* **Название:** Корзина, **Собирать подробную статистику** - Да, **Условия: URL страницы**, url: содержит -> checkout/cart/, **Типы целей интернет-магазинов** - Да, эта цель описывает корзину на моём сайте
* **Название:** Заказ, **Собирать подробную статистику** - Да, **Условия: URL страницы**, url: содержит -> checkout/onepage/success, **Типы целей интернет-магазинов** - Да, эта цель описывает подтверждение заказа на моём сайте

Версия 1.* для Magento 1
Версия 2.* для Magento 2


### Yandex Metrica Magento intergration extension

Simple and quick counter integration for Magento e-commerce store

* Counter integration to start of all pages (after_body_start section)
* «Ecommerce parameters» report http://help.yandex.com/metrica/content/e-commerce.xml

=======
www.mygento.ru
