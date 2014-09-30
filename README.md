apihour.net
===========

CRM+


<h2>1. Instalacja</h2>

1. Wchodzimy do katalogu w którym mamy nasze projekty.

2. W konsoli uruchamiamy: 
<pre>git clone https://github.com/jedenplusjeden/apihour.net.git</pre>
3. Wpiwujemy swoje dane do logowania.
4. wpisujemy
<pre>cd apihour.net/</pre> jeśli tak nazywa się nasz projekt.
5. Następnie, żeby zainstalować composera (jeśli go nie mamy) w konsoli wpisujemy:
<pre>curl -sS https://getcomposer.org/installer | php</pre> 
6. Na końcu wpisujemy:
<pre>php composer.phar install</pre>
żeby nasz composer dociągnął zależności w naszym projekcie (Symfony, FOSUserBundle, KnpMenuBundle, ...).
7. Na końcu będziemy musieli uzupełnić nasz plik "/app/config/parameters.yml". Automatycznie po dociągnięciu zależności przez composer`a możemy wpisać w konsoli(dane do MySQL, dane do maila, itp...).
8. Po instalacji trzeba będzie jeszcze wyczyścić cache oraz zainstalować css, js. Musimy być w naszym projekcie. W konsoli wpisujemy:
<pre>php app/console cache:clear</pre>
<pre>php app/console assets:install --relative</pre>
<pre>php app/console assetic:dump</pre>

W tym momecie nasz projekt jest już skonfigurowany.

<h2>2. Instalacja bazy na lokalu. </h2>
1. Najpier musimy zmienić dane do bazy (login, hasło, host, port, itp..) w pliku "parameters.yml" w katalogu: app/config. <i>Wpisujemy dane do naszego lokalnego serwera baz danych.</i>
2. W konsoli wpisujemy kolejno:
<pre>php app/console doctrine:schema:update --force</pre> - do wgrania struktury bazy danych
<pre>php app/console doctrine:migrations:migrate</pre> - do wgrania podstawowych danych
