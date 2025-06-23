Instalacja projektu: Katalog internetowy

1. Sklonuj repozytorium do własnego katalogu z aplikacją:
   git clone https://github.com/NoiraFF/projekt_si.git

2. Przejdź do katalogu z aplikacją.
3. W pliku .env ustawiamy dane dostępowe do bazy danych.
   Zmieniamy: (DATABASE_URL="mysql://symfony:symfony@mysql:3306/symfony")

4. Instalujemy zależności:
   composer install

5. ładujemy migracje bazodanowe i zapełniamy bazę danych losowymi danymi:
   php bin/console doctrine:migrations:migrate
   php bin/console doctrine:fixtures:load
