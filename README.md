# 🅿️R1PARKING PROJECT🅿️

***Hello!*** Here you can learn everything about my **R1 Parking project.**

> !!! The development of the project is in progress. Functional content will be supplemented in the future.

## Description


🚗 R1 Parking located in *Warsaw, Poland*, not far from Warsaw Chopin Airport.
It provides *service of long-term parking* for the duration of your trip or for your other purposes.

🚗 *The main aims of the project are:*
1) making the parking more convenient with **the functionality of booking parking places by clients online**,
2) **automation and digitalization** of parking company data **for employer and employees.**

The project includes *two parts*: **parking site for clients** and **Admin Panel** for parking employees. Learn more about them below!

> [Here is the link to the parking site!](http://sredarazrabotki.space/PL/R1.php)

# 1. Clients part
🚗 The main purpose of this part is to provide client an ability to book parking place ***as quickly and simply*** as possible.

🚗 The first step for booking is just *entering required time interval of parking*.

![First booking step](https://github.com/miletovaa/r1parking/blob/main/readme_img/photo_2022-03-16_01-26-16.jpg)

🚗 Then the site calculates and provides client the cost for entered period. Next, client fills simple form with *only two fields required* (Name and Phone Number).

![Second booking step](https://github.com/miletovaa/r1parking/blob/main/readme_img/photo_2022-03-16_01-26-07.jpg)

🚗 If it's your first reservation, you will get an SMS to verify your phone number.

![SMS](https://github.com/miletovaa/r1parking/blob/main/readme_img/sms.jpg)

🚗 Next page allows client to fill *some optional details* about reservation, additional services and payment method. Here client also can request *a VAT invoice* that will be *generated and sent to the email automatically.*

![Third booking step](https://github.com/miletovaa/r1parking/blob/main/readme_img/photo_2022-03-16_01-26-26.jpg)

🚗 **That's it!** A few minutes and client has booked parking place at R1.

![Finish](https://github.com/miletovaa/r1parking/blob/main/readme_img/finish.jpg)

🚗 If you entered your e-mail, you will get a letter with verification link. After verification of e-mail, your just generated reservation file (and VAT invoice) will be sent to it immediately.

![Reservation file](https://github.com/miletovaa/r1parking/blob/main/readme_img/reservation.jpg)

![VAT](https://github.com/miletovaa/r1parking/blob/main/readme_img/vat.jpg)

Further registered clients have an ability to log in using input field in header. It makes creation of future reservations faster and simplier.

![Header](https://github.com/miletovaa/r1parking/blob/main/readme_img/header.jpg)

Code checks if registered client uses the same device as earlier and automatically enters known information. In case that client uses a new device, code sends SMS-code to verify client and protect user's data.

## Other pages
Client's part also includes *Contacts* and *Price* pages.

![Contacts page](https://github.com/miletovaa/r1parking/blob/main/readme_img/contacts.jpg)
##  Translation module

🚗 Client's part is available ***in 3 languages*** (English, Polish and Russian). All site text data stored in the  Database (in each available languages) and can be ***changed easily anytime***.

# 2. Admin Panel
🚗 This part of project makes ***work of parking faster and simplier***.

## Notification system
🚗 Every time system gets new order, admin gets Telegram notification about it immediately.
![Unconfirmed order](https://github.com/miletovaa/r1parking/blob/main/readme_img/tg1.jpg)
![Confirmed order](https://github.com/miletovaa/r1parking/blob/main/readme_img/tg2.jpg)

## Admins system
🚗 Here are some *levels* that admin may have.
1) **1-level admin** has all rights of the Admin Panel. You can edit settings of the site *(more about it below)*, add and delete admins, view the daily resume, the full list of reservations and update them.
2) **2-level admin** can view the daily resume, the full list of reservations and update them.
3) **3-level admin** can only view the daily resume, the full list of reservations.

## Daily resume for employees
🚗 Everyday employees see ***a list of cars that should arrive or leave today*** and all  the necessary information: arrival or departure date and time, car registrations, car owners details, etc.

![Orders list](https://github.com/miletovaa/r1parking/blob/main/readme_img/photo_2022-03-16_01-59-01.jpg)

🚗 Admin can print automatically generated bill any time.

![Bill](https://github.com/miletovaa/r1parking/blob/main/readme_img/rachunek.jpg)

🚗 System also keeps track of overdue orders. If any car should have left parking for today but still on the parking, you see it like on the picture below:

![Delayed orders](https://github.com/miletovaa/r1parking/blob/main/readme_img/debt.jpg)

## Raports
🚗 Any time admin can generate a raport about required orders with ability to print them quickly. (It can be a list of orders for one day or few selected days)

![Raport](https://github.com/miletovaa/r1parking/blob/main/readme_img/raport.jpg)

## Edit settings page

🚗 The **1-level admins** have an ability **to edit some site data** such as prices for parking, depending on period, prices of additional services.

All this data stored in the Database and **all changes will be available** on the client's site **immediately**.

![Edit settings page](https://github.com/miletovaa/r1parking/blob/main/readme_img/photo_2022-03-16_02-08-34.jpg)

🚗 Also, this page provides admin an ability to add and delete admins.

![Admins](https://github.com/miletovaa/r1parking/blob/main/readme_img/photo_2022-03-16_02-09-39.jpg)

