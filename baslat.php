<?php
error_reporting(0);
require 'fonksiyon.php';
require 'var.php';
echo $cln;
system("clear");
sitebilgi_banner();
if (extension_loaded('curl') || extension_loaded('dom'))
  {
  }
else
  {
    if (!extension_loaded('curl'))
      {
        echo $bold . $red . "\n[!]cURL Modülü Eksik! 'Düzelt' komutunu deneyin VEYA yükleyin php-curl" . $cln;
      }
    if (!extension_loaded('dom'))
      {
        echo $bold . $red . "\n[!]DOM Modülü Eksik! 'Düzelt' komutunu deneyin VEYA Kur php-xml\n" . $cln;
      }
  }
thephuckinstart:
echo "\n";
userinput("Taramak İstediğiniz Web Sitesini Yazın");
$ip = trim(fgets(STDIN, 1024));
if ($ip == "help")
  {
    echo "\n\n[+]SITE BILGI YARDIM EKRANI[+]\n\n";
    echo $bold . $lblue . "Komutlar\n";
    echo "========\n";
    echo $fgreen . "[1] yardım:$cln Yardım Menüsünü Görüntüle\n";
    echo $bold . $fgreen . "[2] düzeltme:$cln Gerekli Tüm Modülleri Yükler (Aracı İlk Defa Çalıştırırsanız Önerilen)\n";
    echo $bold . $fgreen . "[3] URL:$cln Taramak İstediğiniz Alan Adını Girin (Format: www.ornek.com / ornek.com)\n";
    goto thephuckinstart;
  }
elseif ($ip == "fix")
  {
    echo "\n\e[91m\e[1m[+] SITE BILGI TAMIR EKRANI [+]\n\n$cln";
    echo $bold . $blue . "[+] CURL modülü kurulu ise kontrol ediliyor ...\n";
    if (!extension_loaded('curl'))
      {
        echo $bold . $red . "[!] cURL Modülü Indirilmedi! \n";
        echo $yellow . "[*] CURL kurulumu. (Operasyon sudo izni gerektirir, bu yüzden parola istenebilir) \n" . $cln;
        system("sudo apt-get -qq --assume-yes install php-curl");
        echo $bold . $fgreen . "[i] cURL Yüklendi. \n";
      }
    else
      {
        echo $bold . $fgreen . "[i] cURL zaten kurulu, Bir Sonrakine Geç \n";
      }
    echo $bold . $blue . "[+] Php-XML modülü kurulumu denetleniyor ...\n";
    if (!extension_loaded('dom'))
      {
        echo $bold . $red . "[!] php-XML Modülü Yüklenmedi! \n";
        echo $yellow . "[*] Php-XML kurulumu. (Operasyon sudo izni gerektirir, bu yüzden parola istenebilir) \n" . $cln;
        system("sudo apt-get -qq --assume-yes install php-xml");
        echo $bold . $fgreen . "[i] DOM Yüklendi. \n";
      }
    else
      {
        echo $bold . $fgreen . "[i] php-XML zaten kurulu, Hepsi SET;) \n";
      }
    echo $bold . $fgreen . "[i] İş başarıyla tamamlandı! Lütfen SITE BILGI'ı yeniden başlatın \n";
    exit;
  }
elseif (strpos($ip, '://') !== false)
  {
    echo $bold . $red . "\n[!] (HTTP/HTTPS) Girdigi Algılandı! URL Olmadan Gir Http/Https\n" . $CURLOPT_RETURNTRANSFER;
    goto thephuckinstart;
  }
elseif (strpos($ip, '.') == false)
  {
    echo $bold . $red . "\n[!] Geçersiz URL Formatı! Geçerli bir URL girin\n" . $cln;
    goto thephuckinstart;
  }
elseif (strpos($ip, ' ') !== false)
  {
    echo $bold . $red . "\n[!] Geçersiz URL Formatı! Geçerli bir URL girin\n" . $cln;
    goto thephuckinstart;
  }
else
  {
    echo "\n";
    userinput("HTTP için 1 girin VEYA HTTPS için 2 girin");
    echo $cln . $bold . $fgreen;
    $ipsl = trim(fgets(STDIN, 1024));
    if ($ipsl == "2")
      {
        $ipsl = "https://";
      }
    else
      {
        $ipsl = "http://";
      }
scanlist:

    system("clear");
    echo $bold . $blue . "
      +--------------------------------------------------------------+
      +                  Taramaların veya İşlemlerin Listesi                    +
      +--------------------------------------------------------------+

            $lblue Siteyi Taraması : " . $fgreen . $ipsl . $ip . $blue . "
      \n\n";
    echo $yellow . " [0]  Basic Recon$white (Site Baslıgı, Sitenin IP Adresi, CMS, Cloudflare Bulma, Robots.txt Taraması)$yellow \n [1] Whois Araması \n [2] Coğrafi IP Araması \n [3] Afiş Tutun \n [4] DNS Araması \n [5] Alt Ağ Hesaplayıcısı \n [6] NMAP Bağlantı Noktası Taraması \n [7] Alt etki alanı Tarayıcı \n [8] Ters IP Araması ve CMS Algılama \n [9] SQLi Tarayıcı$white(Parametre ile Bağlantıları Buluyor ve Hata Tabanlı SQLi İçin Taramaları Buluyor)$yellow \n [10] Blogcular Görüntüle $white (Blogcuların İlgilenebileceği Bilgi)$yellow \n [11] WordPress Taraması$white (Yalnızca Hedef Site WP’de Çalışıyorsa)$yellow \n [12] Böcek \n [13] MX Lookup \n$magenta [A]  Her Şeyi Tara - (Eski Lame Tarayıcı) \n$blue [F]  Düzeltme (Gerekli Modüller İçin Kontroller ve Eksik Olanları Kurma) \n$fgreen [U]  Güncellemeleri kontrol et \n$white [B]  Başka Bir Web Sitesini Tara (Site Seçimine Dön) \n$red [Q]  Çıkış! \n\n" . $cln;
askscan:
    userinput("Yukarıdaki Listeden Herhangi Bir Tarama VEYA Eylemi Seçme");
    $scan = trim(fgets(STDIN, 1024));

    if (!in_array($scan, array(
        '0',
        '1',
        '2',
        '3',
        '4',
        '5',
        '6',
        '7',
        '8',
        '9',
        '10',
        '11',
        '12',
        '13',
        'F',
        'f',
        'A',
        'B',
        'U',
        'Q',
        'a',
        'b',
        'q',
        'u'
    ), true))
      {
        echo $bold . $red . "\n[!] Geçersiz Giriş! Lütfen Geçerli Bir Seçenek Girin! \n\n" . $cln;
        goto askscan;
      }
    else
      {
        if ($scan == "15")
          {
            goto thephuckinstart;
          }
        elseif ($scan == 'q' | $scan == 'Q')
          {
            echo "\n\n\t Güle güle, iyi günler :)\n\n";
            die();
          }
        elseif ($scan == 'b' || $scan == 'B')
          {
            system("clear");
            goto thephuckinstart;
          }
        elseif ($scan == "0")
          {
            $reallink = $ipsl . $ip;
            $lwwww    = str_replace("www.", "", $ip);
            echo "\n$cln" . $lblue . $bold . "[+] Tarama Başlıyor ... \n";
            echo $blue . $bold . "[i] Taranan Site:\e[92m $ipsl" . "$ip \n";
            echo $bold . $yellow . "[S] Tarama Türü : Basit Tarama" . $cln;
            echo "\n\n";
            echo $bold . $lblue . "[iNFO] Site Başlığı: " . $green;
            echo getTitle($reallink);
            echo $cln;
            $wip = gethostbyname($ip);
            echo $lblue . $bold . "\n[iNFO] IP Adresi: " . $green . $wip . "\n" . $cln;
            echo $bold . $lblue . "[iNFO] Site Sunucusu: ";
            WEBserver($reallink);
            echo "\n";
            echo $bold . $lblue . "[iNFO] CMS: \e[92m" . CMSdetect($reallink) . $cln;
            echo $lblue . $bold . "\n[iNFO] Cloudflare: ";
            cloudflaredetect($lwwww);
            echo $lblue . $bold . "[iNFO] Robots Dosyası:$cln ";
            robotsdottxt($reallink);
            echo "\n\n";
            echo $bold . $yellow . "[*] Tarama tamamlandı. Devam etmek için Enter tuşuna basın Durdurmak için CTRL + C tuşlarına basın \n\n";
            trim(fgets(STDIN, 1024));
            goto scanlist;
          }
        elseif ($scan == "1")
          {
            $reallink = $ipsl . $ip;
            $lwwww    = str_replace("www.", "", $ip);
            echo "\n$cln" . $lblue . $bold . "[+] Tarama Başlıyor ... \n";
            echo $blue . $bold . "[i] Taranan Site:\e[92m $ipsl" . "$ip \n";
            echo $bold . $yellow . "[S] Tarama Türü: WHOIS Araması" . $cln;
            echo $bold . $lblue . "\n[~] Whois Araması Sonucu: \n\n" . $cln;
            $urlwhois    = "http://api.hackertarget.com/whois/?q=" . $lwwww;
            $resultwhois = file_get_contents($urlwhois);
            echo $bold . $fgreen . $resultwhois;
            echo "\n\n";
            echo $bold . $yellow . "[*] Tarama tamamlandı. Devam etmek için Enter tuşuna basın Durdurmak için CTRL + C tuşlarına basın\n\n";
            trim(fgets(STDIN, 1024));
            goto scanlist;
          }
        elseif ($scan == "2")
          {
            $reallink = $ipsl . $ip;
            $lwwww    = str_replace("www.", "", $ip);
            echo "\n$cln" . $lblue . $bold . "[+] Tarama Başlıyor ... \n";
            echo $blue . $bold . "[i] Taranan Site:\e[92m $ipsl" . "$ip \n";
            echo $bold . $yellow . "[S] Tarama Türü : GEO-IP Araması" . $cln;
            echo "\n\n";
            $urlgip    = "http://api.hackertarget.com/geoip/?q=" . $lwwww;
            $resultgip = readcontents($urlgip);
            $geoips    = explode("\n", $resultgip);
            foreach ($geoips as $geoip)
              {
                echo $bold . $lblue . "[GEO-IP]$green $geoip \n";
              }
            echo "\n\n";
            echo $bold . $yellow . "[*] Tarama tamamlandı. Devam etmek için Enter tuşuna basın Durdurmak için CTRL + C tuşlarına basın\n\n";
            trim(fgets(STDIN, 1024));
            goto scanlist;
          }
        elseif ($scan == "3")
          {
            $reallink = $ipsl . $ip;
            $lwwww    = str_replace("www.", "", $ip);
            echo "\n$cln" . $lblue . $bold . "[+] Tarama Başlıyor ... \n";
            echo $blue . $bold . "[i] Taranan Site:\e[92m $ipsl" . "$ip \n";
            echo $bold . $yellow . "[S] Tarama Türü : Afiş Kapma" . $cln;
            echo "\n\n";
            $hdr = get_headers($reallink);
            foreach ($hdr as $shdr)
              {
                echo $bold . $lblue . "\n" . $green . $shdr;
              }
            echo "\n\n";
            echo $bold . $yellow . "[*] Tarama tamamlandı. Devam etmek için Enter tuşuna basın Durdurmak için CTRL + C tuşlarına basın\n\n";
            trim(fgets(STDIN, 1024));
            goto scanlist;
          }
        elseif ($scan == "4")
          {
            $reallink = $ipsl . $ip;
            $lwwww    = str_replace("www.", "", $ip);
            echo "\n$cln" . $lblue . $bold . "[+]  Tarama Başlıyor ... \n";
            echo $blue . $bold . "[i] Taranan Site:\e[92m $ipsl" . "$ip \n";
            echo $bold . $yellow . "[S] Tarama Türü : DNS Aramaso" . $cln;
            echo "\n\n";
            $urldlup    = "http://api.hackertarget.com/dnslookup/?q=" . $lwwww;
            $resultdlup = readcontents($urldlup);
            $dnslookups = trim($resultdlup, "\n");
            $dnslookups = explode("\n", $dnslookups);
            foreach ($dnslookups as $dnslkup)
              {
                echo $bold . $lblue . "\n[DNS Lookup] " . $green . $dnslkup;
              }
            echo "\n\n";
            echo $bold . $yellow . "[*] Tarama tamamlandı. Devam etmek için Enter tuşuna basın Durdurmak için CTRL + C tuşlarına basın\n\n";
            trim(fgets(STDIN, 1024));
            goto scanlist;
          }
        elseif ($scan == "5")
          {
            $reallink = $ipsl . $ip;
            $lwwww    = str_replace("www.", "", $ip);
            echo "\n$cln" . $lblue . $bold . "[+] Tarama Başlıyor ... \n";
            echo $blue . $bold . "[i] Siteyi Tarama:\e[92m $ipsl" . "$ip \n";
            echo $bold . $yellow . "[S] Tarama Türü : SubNet Hesap Makinesi" . $cln;
            echo "\n\n";
            $urlscal    = "http://api.hackertarget.com/subnetcalc/?q=" . $lwwww;
            $resultscal = readcontents($urlscal);
            $subnetcalc = trim($resultscal, "\n");
            $subnetcalc = explode("\n", $subnetcalc);
            foreach ($subnetcalc as $sc)
              {
                echo $bold . $lblue . "\n[SubNet Calc] " . $green . $sc;
              }
            echo "\n\n";
            echo $bold . $yellow . "[*] Tarama tamamlandı. Devam etmek için Enter tuşuna basın Durdurmak için CTRL + C tuşlarına basın\n\n";
            trim(fgets(STDIN, 1024));
            goto scanlist;
          }
        elseif ($scan == "7")
          {
            $reallink = $ipsl . $ip;
            $lwwww    = str_replace("www.", "", $ip);
            echo "\n$cln" . $lblue . $bold . "[+] Tarama Başlıyor ... \n";
            echo $blue . $bold . "[i] Taranan Site:\e[92m $ipsl" . "$ip \n";
            echo $bold . $yellow . "[S] Tarama Türü : Subdomain Taraması" . $cln;
            $urlsd      = "http://api.hackertarget.com/hostsearch/?q=" . $lwwww;
            $resultsd   = readcontents($urlsd);
            $subdomains = trim($resultsd, "\n");
            $subdomains = explode("\n", $subdomains);
            unset($subdomains['0']);
            $sdcount = count($subdomains);
            echo "\n" . $blue . $bold . "[i] Bulunan Toplam SubDomain : " . $green . $sdcount . "\n\n" . $cln;
            foreach ($subdomains as $subdomain)
              {
                echo $bold . $lblue . "[+] Subdomain: $fgreen" . (str_replace(",", "\n\e[36m[-] IP: $fgreen", $subdomain));
                echo "\n\n" . $cln;
              }
            echo $bold . $yellow . "[*] Tarama tamamlandı. Devam etmek için Enter tuşuna basın Durdurmak için CTRL + C tuşlarına basın\n\n";
            trim(fgets(STDIN, 1024));
            goto scanlist;
          }
        elseif ($scan == "6")
          {
            $reallink = $ipsl . $ip;
            $lwwww    = str_replace("www.", "", $ip);
            echo "\n$cln" . $lblue . $bold . "[+] Tarama Başlıyor ... \n";
            echo $blue . $bold . "[i] Taranan Site:\e[92m $ipsl" . "$ip \n";
            echo $bold . $yellow . "[S] Tarama Türü : Nmap Bağlantı Noktası Taraması" . $cln;
            echo $bold . $lblue . "\n[~] Port Tarama Sonucu: \n\n" . $cln;
            $urlnmap    = "http://api.hackertarget.com/nmap/?q=" . $lwwww;
            $resultnmap = readcontents($urlnmap);
            echo $bold . $fgreen . $resultnmap;
            echo "\n\n";
            echo $bold . $yellow . "[*] Tarama tamamlandı. Devam etmek için Enter tuşuna basın Durdurmak için CTRL + C tuşlarına basın\n\n";
            trim(fgets(STDIN, 1024));
            goto scanlist;
          }
        elseif ($scan == "8")
          {
            $reallink  = $ipsl . $ip;
            $lwwww     = str_replace("www.", "", $ip);
            $detectcms = "yes";
            echo "\n$cln" . $lblue . $bold . "[+] Tarama Başlıyor ... \n";
            echo $blue . $bold . "[i] Taranan Site:\e[92m $ipsl" . "$ip \n";
            echo $bold . $yellow . "[S] Tarama Türü : Ters IP Araması ve CMS Algılama" . $cln;
            echo "\n";
            $sth = 'http://domains.yougetsignal.com/domains.php';
            $ch  = curl_init($sth);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "remoteAddress=$ip&ket=");
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_POST, 1);
            $resp  = curl_exec($ch);
            $resp  = str_replace("[", "", str_replace("]", "", str_replace("\"\"", "", str_replace(", ,", ",", str_replace("{", "", str_replace("{", "", str_replace("}", "", str_replace(", ", ",", str_replace(", ", ",", str_replace("'", "", str_replace("'", "", str_replace(":", ",", str_replace('"', '', $resp)))))))))))));
            $array = explode(",,", $resp);
            unset($array[0]);

            echo $bold . $lblue . "[i] Bu Sunucuda Bulunan Toplam Site :$cln " . $green . count($array) . "\n\n$cln";
            if (count($array) > 0)
              {
                userinput("SITE BILGI'nin Sitelerin CMS'sini Algılamasını İstiyor musunuz? [Y/N]");
                $detectcmsui = trim(fgets(STDIN, 1024));
                if ($detectcmsui == "y" | $detectcmsui == "Y")
                  {
                    $detectcms = "yes";
                  }
                else
                  {
                    $detectcms = "no";
                  }
              }
            foreach ($array as $izox)
              {
                $izox   = str_replace(",", "", $izox);
                $cmsurl = "http://" . $izox;
                echo "\n" . $bold . $lblue . "SUNUCU-ADI : " . $fgreen . $izox . $cln;
                echo "\n" . $bold . $lblue . "IP       : " . $fgreen . gethostbyname($izox) . $cln . "\n";
                if ($detectcms == "yes")
                  {
                    echo $lblue . $bold . "CMS      : " . $green . CMSdetect($cmsurl) . $cln . "\n\n";
                  }
              }
            echo "\n\n";
            echo $bold . $yellow . "[*] Tarama tamamlandı. Devam etmek için Enter tuşuna basın Durdurmak için CTRL + C tuşlarına basın\n\n";
            trim(fgets(STDIN, 1024));
            goto scanlist;
          }
        elseif ($scan == "9")
          {
            $reallink = $ipsl . $ip;
            $srccd    = file_get_contents($reallink);
            $lwwww    = str_replace("www.", "", $ip);
            echo "\n$cln" . $lblue . $bold . "[+] Tarama Başlıyor ... \n";
            echo $blue . $bold . "[i] Taranan Site :\e[92m $ipsl" . "$ip \n";
            echo $bold . $yellow . "[S] Tarama Türü : SQL Güvenlik Açığı Tarayıcısı" . $cln;
            echo "\n\n";
            $lulzurl = $reallink;
            $html    = file_get_contents($lulzurl);
            $dom     = new DOMDocument;
            @$dom->loadHTML($html);
            $links = $dom->getElementsByTagName('a');
            $vlnk  = 0;
            foreach ($links as $link)
              {
                $lol = $link->getAttribute('href');
                if (strpos($lol, '?') !== false)
                  {
                    echo $lblue . $bold . "\n[ LINK ] " . $fgreen . $lol . "\n" . $cln;
                    echo $blue . $bold . "[ SQLi ] ";
                    $sqllist = file_get_contents('sqlerrors.ini');
                    $sqlist  = explode(',', $sqllist);
                    if (strpos($lol, '://') !== false)
                      {
                        $sqlurl = $lol . "'";
                      }
                    else
                      {
                        $sqlurl = $ipsl . $ip . "/" . $lol . "'";
                      }
                    $sqlsc = file_get_contents($sqlurl);
                    $sqlvn = $bold . $red . "Açık Değil";
                    foreach ($sqlist as $sqli)
                      {
                        if (strpos($sqlsc, $sqli) !== false)
                            $sqlvn = $green . $bold . "Açık Var!";
                      }
                    echo $sqlvn;
                    echo "\n$cln";
                    echo "\n";
                    $vlnk++;
                  }
              }
            echo "\n" . $blue . $bold . "[+] URL'ler) Parametrelerle): " . $green . $vlnk;
            echo "\n\n";
            echo $bold . $yellow . "[*] Tarama tamamlandı. Devam etmek için Enter tuşuna basın Durdurmak için CTRL + C tuşlarına basın\n\n";
            trim(fgets(STDIN, 1024));
            goto scanlist;
          }
        elseif ($scan == "10")
          {
            $reallink = $ipsl . $ip;
            $srccd    = readcontents($reallink);
            $lwwww    = str_replace("www.", "", $ip);
            echo "\n$cln\t" . $lblue . $bold . "[+] BLOG`U GÖSTER [+] \n\n";
            echo $blue . $bold . "[i] Taranan Site:\e[92m $ipsl" . "$ip \n";
            echo "\n\n";
            $test_url = $reallink;
            $handle   = curl_init($test_url);
            curl_setopt($handle, CURLOPT_RETURNTRANSFER, TRUE);
            $tu_response        = curl_exec($handle);
            $test_url_http_code = curl_getinfo($handle, CURLINFO_HTTP_CODE);
            echo $lblue . $bold . "[i] HTTP Yanıt Kodu : " . $fgreen . $test_url_http_code . "\n";
            echo $lblue . "[i] Site Başlığı: " . $fgreen . getTitle($reallink) . "\n";
            echo $lblue . "[i] CMS (İçerik yönetim sistemi) : " . $fgreen . CMSdetect($reallink) . "\n";
            echo $lblue . $bold . "[i] Alexa Küresel Sıralaması : " . $fgreen . bv_get_alexa_rank($lwwww) . "\n";
            bv_moz_info($lwwww);
            extract_social_links($srccd);
            extractLINKS($reallink);
            echo "\n\n";
            echo $bold . $yellow . "[*] Tarama tamamlandı. Devam etmek için Enter tuşuna basın Durdurmak için CTRL + C tuşlarına basın\n\n";
            trim(fgets(STDIN, 1024));
            goto scanlist;
          }
        elseif ($scan == "11")
          {
            userinput("WordPress'in kurulu olduğu dizine girin (örneğin /blog) Eğer çalışıyorsa " . $ipsl . $ip . " simply press ENTER");
            $wp_inst_loc = trim(fgets(STDIN, 1024));
            if ($wp_inst_loc == "")
              {
                $reallink = $ipsl . $ip;
              }
            else
              {
                $reallink = $ipsl . $ip . $wp_inst_loc;
              }
            echo "\n$cln" . $lblue . $bold . "[+] Tarama Başlıyor ... \n";
            echo $blue . $bold . "[i] Taranan Site:\e[92m $reallink \n";
            echo $bold . $yellow . "[S] Tarama Türü : WordPress Taraması." . $cln;
            echo "\n\n";
            echo $bold . $blue . "[+] Sitenin WordPress üzerine kurulu olup olmadığını kontrol etme: ";
            $srccd = readcontents($reallink);
            if (strpos($srccd, "wp-content") !== false)
              {
                echo $fgreen . "Belirlenen !" . $cln . "\n";
                echo $bold . $yellow . "\n\t Temel kontroller \n\t==============\n\n";
                $wp_rm_src = readcontents($reallink . "/readme.html");
                if (strpos($wp_rm_src, "Hoşgeldiniz. WordPress benim için çok özel bir proje.") !== false)
                  {
                    echo $fgreen . "[i] Benioku Dosyası Bulundu, Bağlantı: " . $reallink . "/readme.html\n";
                  }
                else
                  {
                    echo $red . "[!] Benioku Dosyası Bulunamadı!\n";
                  }
                $wp_lic_src = readcontents($reallink . "/license.txt");
                if (strpos($wp_lic_src, "WordPress - Web yayıncılığı yazılımı") !== false)
                  {
                    echo $fgreen . "[i] Lisans Dosyası Bulundu, Bağlantı: " . $reallink . "/license.txt\n";
                  }
                else
                  {
                    echo $red . "[!] Lisans Dosyası Bulunamadı!\n";
                  }
                $wp_updir_src = readcontents($reallink . "/wp-content/uploads/");
                if (strpos($wp_updir_src, "Index of /wp-content/uploads") !== false)
                  {
                    echo $fgreen . $reallink . "/wp-content/uploads Göz Atılabilir\n";
                  }
                $wp_xmlrpc_src = readcontents($reallink . "/xmlrpc.php");
                if (strpos($wp_xmlrpc_src, "XML-RPC sunucu yalnızca POST isteklerini kabul eder.") !== false)
                  {
                    echo $fgreen . "[i] XML-RPC Arayüz Altında " . $reallink . "/xmlrpc.php\n";
                  }
                else
                  {
                    echo $red . "[!] XML-RPC arayüzü bulunamadı\n";
                  }
                echo $bold . $blue . "[+] WordPress Sürümünü Bulma: ";
                $metaver = preg_match('/<meta name="generator" content="WordPress (.*?)\"/ims', $srccd, $matches) ? $matches[1] : null;
                if ($metaver != "")
                  {
                    echo $fgreen . "Bulundu [kullanma yöntemi 3`den 1]" . "\n";
                    echo $blue . "[i] WordPress Sürümü: " . $fgreen . $metaver . $cln;
                    $wp_version   = str_replace(".", "", $metaver);
                    $wp_c_version = $metaver;
                  }
                else
                  {
                    $feedsrc = readcontents($reallink . "/feed/");
                    $feedver = preg_match('#<generator>http://wordpress.org/\?v=(.*?)</generator>#ims', $feedsrc, $matches) ? $matches[1] : null;
                    if ($feedver != "")
                      {
                        echo $fgreen . "Bulundu [kullanma yöntemi 3`den 2]" . "\n";
                        echo $blue . "[i] WordPress Sürümü: " . $fgreen . $feedver . $cln;
                        $wp_version   = str_replace(".", "", $feedver);
                        $wp_c_version = $feedver;
                      }
                    else
                      {
                        $lopmlsrc = readcontents($reallink . "/wp-links-opml.php");
                        $lopmlver = preg_match('#generator="wordpress/(.*?)"#ims', $feedsrc, $matches) ? $matches[1] : null;
                        if ($lopmlver != "")
                          {
                            echo $fgreen . "Bulundu [kullanma yöntemi 3`den 3]" . "\n";
                            echo $blue . "[i] WordPress Sürümü: " . $fgreen . $lopmlver . $cln;
                            $wp_version   = str_replace(".", "", $lopmlver);
                            $wp_c_version = $lopmlver;
                          }
                      }
                  }
                if ($wp_version != "")
                  {
                    echo "\n" . $bold . $blue . "[+] WPVulnDB'den Sürüm Detaylarını Toplama: ";
                    $vuln_json = readcontents("https://wpvulndb.com/api/v2/wordpresses/" . $wp_version);
                    if (strpos($vuln_json, "Aradığınız sayfa mevcut değil (404)") !== false)
                      {
                      
                      }
                    else
                      {
                        $vuln_array = json_decode($vuln_json, TRUE);
                        echo $fgreen . "Kabul\n\n";
                        echo $yellow . "\t WordPress Sürüm Bilgileri\n\t================================\n\n";
                        echo $lblue . "[i] WordPress Sürümü    : " . $fgreen . $wp_c_version . "\n";
                        echo $lblue . "[i] Yayın tarihi        : " . $fgreen . $vuln_array[$wp_c_version]["release_date"] . "\n";
                        echo $lblue . "[i] Değişiklik URL'si   : " . $fgreen . $vuln_array[$wp_c_version]["changelog_url"] . "\n";
                        echo $lblue . "[i] Güvenlik açığı sayı : " . $fgreen . count($vuln_array[$wp_c_version]["vulnerabilities"]) . "\n";
                        if (count($vuln_array[$wp_c_version]["açıkları"]) != "0")
                          {
                            echo $yellow . "\n\t Sürüm Açıkları \n\t=========================\n\n";
                            $ver_vuln_array = $vuln_array[$wp_c_version]['açıkları'];
                            foreach ($ver_vuln_array as $vuln_s)
                              {
                                echo $lblue . "[i] Güvenlik Açığı Başlığı : " . $fgreen . $vuln_s["title"] . "\n";
                                echo $lblue . "[i] Güvenlik Açığı Türü    : " . $fgreen . $vuln_s["vuln_type"] . "\n";
                                echo $lblue . "[i] Sürümde Sabit          : " . $fgreen . $vuln_s["fixed_in"] . "\n";
                                echo $lblue . "[i] Güvenlik Açık Bağlantı : " . $fgreen . "http://wpvulndb.com/vulnerabilities/" . $vuln_s['id'] . "\n";
                                foreach ($vuln_s['references']["cve"] as $wp_cve)
                                  {
                                    echo $lblue . "[i] ihlal CVE          : " . $fgreen . "http://cve.mitre.org/cgi-bin/cvename.cgi?name=CVE-" . $wp_cve . "\n";
                                  }
                                foreach ($vuln_s['references']['DataBase'] as $wp_edb)
                                  {
                                    echo $lblue . "[i] DataBase Bağlantı  : " . $fgreen . "http://www.exploit-db.com/exploits/" . $wp_edb . "\n";
                                  }
                                foreach ($vuln_s['references']['metasploit'] as $wp_metas)
                                  {
                                    echo $lblue . "[i] Metasploit Modülü  : " . $fgreen . "http://www.metasploit.com/modules/" . $wp_metas . "\n";
                                  }
                                foreach ($vuln_s['references']['osvdb'] as $wp_osvdb)
                                  {
                                    echo $lblue . "[i] OSVDB Bağlantısı          : " . $fgreen . "http://osvdb.org/" . $wp_osvdb . "\n";
                                  }
                                foreach ($vuln_s['references']['secunia'] as $wp_secu)
                                  {
                                    echo $lblue . "[i] Secunia Bağlantısı        : " . $fgreen . "http://secunia.com/advisories/" . $wp_secu . "\n";
                                  }
                                foreach ($vuln_s['references']["url"] as $vuln_ref)
                                  {
                                    echo $lblue . "[i] Vuln Referansı      : " . $fgreen . $vuln_ref . "\n";
                                  }
                                echo "\n\n";
                              }
                          }
                      }
                    $reallink = $ipsl . $ip;
                    echo "\n\n";
                    echo $bold . $yellow . "[*] Tarama tamamlandı. Devam etmek için Enter tuşuna basın Durdurmak için CTRL + C tuşlarına basın\n\n";
                    trim(fgets(STDIN, 1024));
                    goto scanlist;
                  }
                else
                  {
                    $reallink = $ipsl . $ip;
                    echo $red . "Başarısız \n\n[!] SITEBILGI, hedefin WordPress sürümünü belirleyemedi!";
                    echo "\n\n";
                    echo $bold . $yellow . "[*] Tarama tamamlandı. Devam etmek için Enter tuşuna basın Durdurmak için CTRL + C tuşlarına basın\n\n";
                    trim(fgets(STDIN, 1024));
                    goto scanlist;
                  }
              }
            else
              {
                $reallink = $ipsl . $ip;
                echo $red . "Başarısız \n\n[!] Wordpress kurulumu belirlenemedi, Sca'dan çıkılıyor!";
                echo "\n\n";
                echo $bold . $yellow . "[*] Tarama tamamlandı. Devam etmek için Enter tuşuna basın Durdurmak için CTRL + C tuşlarına basın\n\n";
                trim(fgets(STDIN, 1024));
                goto scanlist;
              }
          }
        elseif ($scan == "12")
          {
            echo "\n$cln" . $lblue . $bold . "[+] Tarama Başlıyor ... \n";
            echo $blue . $bold . "[i] Taranan Site:\e[92m $ipsl" . "$ip \n";
            echo $bold . $yellow . "[S] Tarama Türü : Böcekleme" . $cln;
            echo "\n\n";
            echo $bold . $blue . "\n[i] Böcekli Dosya Yükleme ....\n" . $cln;
            if (file_exists("crawl/admin.ini"))
              {
                echo $bold . $fgreen . "\n[^_^] Yönetici Böcekli Dosya Bulundu! Yönetici Paneli İçin Tarama [-]\n" . $cln;
                $crawllnk = file_get_contents("crawl/admin.ini");
                $crawls   = explode(',', $crawllnk);
                echo "\nURLs yüklü: " . count($crawls) . "\n\n";
                foreach ($crawls as $crawl)
                  {
                    $url    = $ipsl . $ip . "/" . $crawl;
                    $handle = curl_init($url);
                    curl_setopt($handle, CURLOPT_RETURNTRANSFER, TRUE);
                    $response = curl_exec($handle);
                    $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
                    if ($httpCode == 200)
                      {
                        echo $bold . $lblue . "\n\n[U] $url : " . $cln;
                        echo $bold . $fgreen . "Bulundu!" . $cln;
                      }
                    elseif ($httpCode == 404)
                      {
                      }
                    else
                      {
                        echo $bold . $lblue . "\n\n[U] $url : " . $cln;
                        echo $bold . $yellow . "HTTP Tepki: " . $httpCode . $cln;
                      }
                    curl_close($handle);
                  }
              }
            else
              {
                echo "\n Dosya Bulunamadı, Taramayı İptal Etme ....\n";
              }
            if (file_exists("crawl/backup.ini"))
              {
                echo "\n[-] Yedekleme Paletli Dosya Bulundu! Site Yedeklerini Tarama [-]\n";
                $crawllnk = file_get_contents("crawl/backup.ini");
                $crawls   = explode(',', $crawllnk);
                echo "\nURLs Loaded: " . count($crawls) . "\n\n";
                foreach ($crawls as $crawl)
                  {
                    $url    = $ipsl . $ip . "/" . $crawl;
                    $handle = curl_init($url);
                    curl_setopt($handle, CURLOPT_RETURNTRANSFER, TRUE);
                    $response = curl_exec($handle);
                    $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
                    if ($httpCode == 200)
                      {
                        echo $bold . $lblue . "\n\n[U] $url : " . $cln;
                        echo $bold . $fgreen . "Bulundu!" . $cln;
                      }
                    elseif ($httpCode == 404)
                      {
                      }
                    else
                      {
                        echo $bold . $lblue . "\n\n[U] $url : " . $cln;
                        echo $bold . $yellow . "HTTP Tepki: " . $httpCode . $cln;
                      }
                    curl_close($handle);
                  }
              }
            else
              {
                echo "\n Dosya Bulunamadı, Taramayı İptal Etme ....\n";
              }
            if (file_exists("crawl/others.ini"))
              {
                echo "\n[-] Genel Böcekli Dosya Bulundu! Siteyi Tarama [-]\n";
                $crawllnk = file_get_contents("crawl/others.ini");
                $crawls   = explode(',', $crawllnk);
                echo "\nURLs Loaded: " . count($crawls) . "\n\n";
                foreach ($crawls as $crawl)
                  {
                    $url    = $ipsl . $ip . "/" . $crawl;
                    $handle = curl_init($url);
                    curl_setopt($handle, CURLOPT_RETURNTRANSFER, TRUE);
                    $response = curl_exec($handle);
                    $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
                    if ($httpCode == 200)
                      {
                        echo $bold . $lblue . "\n\n[U] $url : " . $cln;
                        echo $bold . $fgreen . "Bulundu!" . $cln;
                      }
                    elseif ($httpCode == 404)
                      {
                      }
                    else
                      {
                        echo $bold . $lblue . "\n\n[U] $url : " . $cln;
                        echo $bold . $yellow . "HTTP Tepki: " . $httpCode . $cln;
                      }
                    curl_close($handle);
                  }
              }
            else
              {
                echo "\n Dosya Bulunamadı, Taramayı İptal Etme ....\n";
              }
          }
        elseif ($scan == "13")
          {
            $reallink = $ipsl . $ip;
            $lwwww    = str_replace("www.", "", $ip);
            echo "\n$cln" . $lblue . $bold . "[+] Tarama Başlıyor ... \n";
            echo $blue . $bold . "[i] Taranan Site:\e[92m $ipsl" . "$ip \n";
            echo $bold . $yellow . "[S] Tarama Türü : MX Lookup" . $cln;
            echo "\n\n";
            echo MXlookup($lwwww);
            echo "\n\n";
            echo $bold . $yellow . "[*] Tarama tamamlandı. Devam etmek için Enter tuşuna basın Durdurmak için CTRL + C tuşlarına basın\n\n";
            trim(fgets(STDIN, 1024));
            goto scanlist;
          }
        elseif ($scan == 'U' || $scan == 'u')
        
        }
        elseif ($scan == "A" || $scan == "a")
          {

            echo "\n$cln" . "$lblue" . "[+] Tarama Başlıyor ... \n";
            echo "$blue" . "[i] Taranan Site:\e[92m $ipsl" . "$ip \n";
            echo "\n\n";

            echo "\n$bold" . "$lblue" . "T E M E L  B I L G I \n";
            echo "====================\n";
            echo "\n\e[0m";

            $reallink = $ipsl . $ip;
            $srccd    = file_get_contents($reallink);
            $lwwww    = str_replace("www.", "", $ip);

            echo "\n$blue" . "[+] Site Başlığı: ";
            echo "\e[92m";
            echo getTitle($reallink);
            echo "\e[0m";


            $wip = gethostbyname($ip);
            echo "\n$blue" . "[+] IP Adresi: ";
            echo "\e[92m";
            echo $wip . "\n\e[0m";

            echo "$blue" . "[+] Site Sunucusu: ";
            WEBserver($reallink);
            echo "\n";

            echo "$blue" . "[+] CMS: \e[92m" . CMSdetect($reallink) . " \e[0m";

            echo "\n$blue" . "[+] Cloudflare: ";
            cloudflaredetect($reallink);

            echo "$blue" . "[+] Robots Dosyası:$cln ";
            robotsdottxt($reallink);
            echo "\n\n$cln";
            echo "\n\n$bold" . $lblue . "W H O I S   A R A M A S I\n";
            echo "========================";
            echo "\n\n$cln";
            $urlwhois    = "http://api.hackertarget.com/whois/?q=" . $lwwww;
            $resultwhois = file_get_contents($urlwhois);
            echo "\t";
            echo $resultwhois;
            echo "\n\n$cln";

            echo "\n\n$bold" . $lblue . "G E O  I P  A R A M A S I\n";
            echo "=========================";
            echo "\n\n$cln";
            $urlgip    = "http://api.hackertarget.com/geoip/?q=" . $lwwww;
            $resultgip = readcontents($urlgip);
            $geoips    = explode("\n", $resultgip);
            foreach ($geoips as $geoip)
              {
                echo $bold . $green . "[i]$cln $geoip \n";
              }
            echo "\n\n$cln";

            echo "\n\n$bold" . $lblue . "H T T P  B A S L I K \n";
            echo "=======================";
            echo "\n\n$cln";
            gethttpheader($reallink);
            echo "\n\n";

            echo "\n\n$bold" . $lblue . "D N S  A R A M A S I \n";
            echo "===================";
            echo "\n\n$cln";
            $urldlup    = "http://api.hackertarget.com/dnslookup/?q=" . $lwwww;
            $resultdlup = file_get_contents($urldlup);
            echo $resultdlup;
            echo "\n\n";

            echo "\n\n$bold" . $lblue . "A L T  A G  H E S A P L A Y I C I S I \n";
            echo "====================================";
            echo "\n\n$cln";
            $urlscal    = "http://api.hackertarget.com/subnetcalc/?q=" . $lwwww;
            $resultscal = file_get_contents($urlscal);
            echo $resultscal;
            echo "\n\n";

            echo "\n\n$bold" . $lblue . "N M A P   P O R T   T A R A M A S I\n";
            echo "============================";
            echo "\n\n$cln";
            $urlnmap    = "http://api.hackertarget.com/nmap/?q=" . $lwwww;
            $resultnmap = file_get_contents($urlnmap);
            echo $resultnmap;
            echo "\n";

            echo "\n\n$bold" . $lblue . "S U B - D O M A I N   A R A M A S I\n";
            echo "==================================";
            echo "\n\n";
            $urlsd      = "http://api.hackertarget.com/hostsearch/?q=" . $lwwww;
            $resultsd   = file_get_contents($urlsd);
            $subdomains = trim($resultsd, "\n");
            $subdomains = explode("\n", $subdomains);
            unset($subdomains['0']);
            $sdcount = count($subdomains);
            echo "\n$blue" . "[i] Bulunan Toplam SubDomain :$cln " . $green . $sdcount . "\n\n$cln";
            foreach ($subdomains as $subdomain)
              {
                echo "[+] Subdomain:$cln $fgreen" . (str_replace(",", "\n\e[0m[-] IP:$cln $fgreen", $subdomain));
                echo "\n\n$cln";
              }
            echo "\n\n";

            echo "\n\n$bold" . $lblue . "T E R S  I P  A R A M A S I\n";
            echo "==================================";
            echo "\n\n";
            $sth = 'http://domains.yougetsignal.com/domains.php';
            $ch  = curl_init($sth);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "remoteAddress=$ip&ket=");
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_POST, 1);
            $resp  = curl_exec($ch);
            $resp  = str_replace("[", "", str_replace("]", "", str_replace("\"\"", "", str_replace(", ,", ",", str_replace("{", "", str_replace("{", "", str_replace("}", "", str_replace(", ", ",", str_replace(", ", ",", str_replace("'", "", str_replace("'", "", str_replace(":", ",", str_replace('"', '', $resp)))))))))))));
            $array = explode(",,", $resp);
            unset($array[0]);
            echo "\n$blue" . "[i] Bu Sunucuda Bulunan Toplam Site :$cln " . $green . count($array) . "\n\n$cln";
            foreach ($array as $izox)
              {
                echo "\n$blue" . "[#]$cln " . $fgreen . $izox . $cln;
                echo "\n$blue" . "[-] CMS:$cln $green";
                $cmsurl = "http://" . $izox;
                $cmssc  = file_get_contents($cmsurl);
                if (strpos($cmssc, '/wp-content/') !== false)
                  {
                    $tcms = "WordPress";
                  }
                else
                  {
                    if (strpos($cmssc, 'Joomla') !== false)
                      {
                        $tcms = "Joomla";
                      }
                    else
                      {
                        $drpurl = "http://" . $izox . "/misc/drupal.js";
                        $drpsc  = file_get_contents($drpurl);
                        if (strpos($drpsc, 'Drupal') !== false)
                          {
                            $tcms = "Drupal";
                          }
                        else
                          {
                            if (strpos($cmssc, '/skin/frontend/') !== false)
                              {
                                $tcms = "Magento";
                              }
                            else
                              {
                                $tcms = $red . "Algılanamadı$cln ";
                              }
                          }
                      }
                  }
                echo $tcms . "\n";
              }

            echo "\n\n";
            echo "\n\n$bold" . $lblue . "S Q L  G Ü V E N L İ K  A Ç I Ğ I  T A R A M A S I\n";
            echo "===================================================$cln";
            echo "\n";
            $lulzurl = $ipsl . $ip;
            $html    = file_get_contents($lulzurl);
            $dom     = new DOMDocument;
            @$dom->loadHTML($html);
            $links = $dom->getElementsByTagName('a');
            $vlnk  = 0;
            foreach ($links as $link)
              {
                $lol = $link->getAttribute('href');
                if (strpos($lol, '?') !== false)
                  {
                    echo "\n$blue [#] " . $fgreen . $lol . "\n$cln";
                    echo $blue . " [-] SQL Hatalarını Arama: ";
                    $sqllist = file_get_contents('sqlerrors.ini');
                    $sqlist  = explode(',', $sqllist);
                    if (strpos($lol, '://') !== false)
                      {
                        $sqlurl = $lol . "'";
                      }
                    else
                      {
                        $sqlurl = $ipsl . $ip . "/" . $lol . "'";
                      }
                    $sqlsc = file_get_contents($sqlurl);
                    $sqlvn = "$red Bulunamadı";
                    foreach ($sqlist as $sqli)
                      {
                        if (strpos($sqlsc, $sqli) !== false)
                            $sqlvn = "$green Bulundu!";
                      }
                    echo $sqlvn;
                    echo "\n$cln";
                    echo "\n";
                    $vlnk++;
                  }
              }
            echo "\n\n$blue [+] URL'ler) Parametrelerle):" . $green . $vlnk;
            echo "\n\n";

            echo "\n\n$bold" . $lblue . "B Ö C E K \n";
            echo "=============";
            echo "\n\n";
            echo "\nCrawling Types & Descriptions:$cln";
            echo "\n\n$bold" . "69:$cln Bu, tarayıcının lite versiyonudur, Bu size '200' kodunu döndüren dosyaları gösterecektir. Bu zaman verimli ve daha az dağınık.\n";
            echo "\n$bold" . "420:$cln Bu, biraz daha önceden bir kodlayıcı olan badboy 404 dışında http kodları ile tüm dosyaların listesini gösterir. Bu biraz karışık ama bilgilendirici \n\n";
csel:
            echo "Böcekli Türü Seç (69/420): ";
            $ctype = trim(fgets(STDIN, 1024));
            if ($ctype == "420")
              {
                echo "\n\t -[ Ö N C E D E N  T A R A M A ]-\n";
                echo "\n\n";
                echo "\n Böcekli Dosyalar Yükleniyor ....\n";
                if (file_exists("crawl/admin.ini"))
                  {
                    echo "\n[-] Yönetici Böcekli Dosya Bulundu! Yönetici Paneli İçin Tarama [-]\n";
                    $crawllnk = file_get_contents("crawl/admin.ini");
                    $crawls   = explode(',', $crawllnk);
                    echo "\nURLs Yüklendi: " . count($crawls) . "\n\n";
                    foreach ($crawls as $crawl)
                      {
                        $url    = $ipsl . $ip . "/" . $crawl;
                        $handle = curl_init($url);
                        curl_setopt($handle, CURLOPT_RETURNTRANSFER, TRUE);
                        $response = curl_exec($handle);
                        $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
                        if ($httpCode == 200)
                          {
                            echo "\n\n[U] $url : ";
                            echo "Bulundu!";
                          }
                        elseif ($httpCode == 404)
                          {
                          }
                        else
                          {
                            echo "\n\n[U] $url : ";
                            echo "HTTP Tepki: " . $httpCode;
                          }
                        curl_close($handle);
                      }
                  }
                else
                  {
                    echo "\n Dosya Bulunamadı, Taramayı İptal Etme ....\n";
                  }
                if (file_exists("crawl/backup.ini"))
                  {
                    echo "\n[-] Yedekleme Paletli Dosya Bulundu! Site Yedeklerini Tarama [-]\n";
                    $crawllnk = file_get_contents("crawl/backup.ini");
                    $crawls   = explode(',', $crawllnk);
                    echo "\nURLs Loaded: " . count($crawls) . "\n\n";
                    foreach ($crawls as $crawl)
                      {
                        $url    = $ipsl . $ip . "/" . $crawl;
                        $handle = curl_init($url);
                        curl_setopt($handle, CURLOPT_RETURNTRANSFER, TRUE);
                        $response = curl_exec($handle);
                        $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
                        if ($httpCode == 200)
                          {
                            echo "\n\n[U] $url : ";
                            echo "Bulundu!";
                          }
                        elseif ($httpCode == 404)
                          {
                          }
                        else
                          {
                            echo "\n\n[U] $url : ";
                            echo "HTTP Tepki: " . $httpCode;
                          }
                        curl_close($handle);
                      }
                  }
                else
                  {
                    echo "\n Dosya Bulunamadı, Taramayı İptal Etme ....\n";
                  }
                if (file_exists("crawl/others.ini"))
                  {
                    echo "\n[-] Genel Böcekli Dosya Bulundu! Siteyi Tarama [-]\n";
                    $crawllnk = file_get_contents("crawl/others.ini");
                    $crawls   = explode(',', $crawllnk);
                    echo "\nURLs Loaded: " . count($crawls) . "\n\n";
                    foreach ($crawls as $crawl)
                      {
                        $url    = $ipsl . $ip . "/" . $crawl;
                        $handle = curl_init($url);
                        curl_setopt($handle, CURLOPT_RETURNTRANSFER, TRUE);
                        $response = curl_exec($handle);
                        $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
                        if ($httpCode == 200)
                          {
                            echo "\n\n[U] $url : ";
                            echo "Bulundu!";
                          }
                        elseif ($httpCode == 404)
                          {
                          }
                        else
                          {
                            echo "\n\n[U] $url : ";
                            echo "HTTP Tepki: " . $httpCode;
                          }
                        curl_close($handle);
                      }
                  }
                else
                  {
                    echo "\n Dosya Bulunamadı, Taramayı İptal Etme ....\n";
                  }
              }
            elseif ($ctype == "69")
              {
                echo "\n\t -[ T E M E L  B Ö C E K L E R ]-\n";
                echo "\n\n";
                echo "\n Böcekli Dosya Yükleme ....\n";
                if (file_exists("crawl/admin.ini"))
                  {
                    echo "\n[-] Yönetici Paletli Dosya Bulundu! Yönetici Paneli İçin Tarama [-]\n";
                    $crawllnk = file_get_contents("crawl/admin.ini");
                    $crawls   = explode(',', $crawllnk);
                    echo "\nURLs Yüklendi: " . count($crawls) . "\n\n";
                    foreach ($crawls as $crawl)
                      {
                        $url    = $ipsl . $ip . "/" . $crawl;
                        $handle = curl_init($url);
                        curl_setopt($handle, CURLOPT_RETURNTRANSFER, TRUE);
                        $response = curl_exec($handle);
                        $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
                        if ($httpCode == 200)
                          {
                            echo "\n\n[U] $url : ";
                            echo "Bulundu!";
                          }
                        elseif ($httpCode == 404)
                          {
                          }
                        else
                          {
                            echo ".";
                          }
                        curl_close($handle);
                      }
                  }
                else
                  {
                    echo "\n Dosya Bulunamadı, Taramayı İptal Etme ....\n";
                  }
                if (file_exists("crawl/backup.ini"))
                  {
                    echo "\n[-] Yedekleme Paletli Dosya Bulundu! Site Yedeklerini Tarama [-]\n";
                    $crawllnk = file_get_contents("crawl/backup.ini");
                    $crawls   = explode(',', $crawllnk);
                    echo "\nURLs Yüklendi: " . count($crawls) . "\n\n";
                    foreach ($crawls as $crawl)
                      {
                        $url    = $ipsl . $ip . "/" . $crawl;
                        $handle = curl_init($url);
                        curl_setopt($handle, CURLOPT_RETURNTRANSFER, TRUE);
                        $response = curl_exec($handle);
                        $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
                        if ($httpCode == 200)
                          {
                            echo "\n\n[U] $url : ";
                            echo "Bulundu!";
                          }
                        elseif ($httpCode == 404)
                          {
                          }
                        curl_close($handle);
                      }
                  }
                else
                  {
                    echo "\n Dosya Bulunamadı, Taramayı İptal Etme ....\n";
                  }
                if (file_exists("crawl/others.ini"))
                  {
                    echo "\n[-] Genel Böcekli Dosya Bulundu! Siteyi Tarama [-]\n";
                    $crawllnk = file_get_contents("crawl/others.ini");
                    $crawls   = explode(',', $crawllnk);
                    echo "\nURLs Yüklendi: " . count($crawls) . "\n\n";
                    foreach ($crawls as $crawl)
                      {
                        $url    = $ipsl . $ip . "/" . $crawl;
                        $handle = curl_init($url);
                        curl_setopt($handle, CURLOPT_RETURNTRANSFER, TRUE);
                        $response = curl_exec($handle);
                        $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
                        if ($httpCode == 200)
                          {
                            echo "\n\n[U] $url : ";
                            echo "Bulundu!";
                          }
                        elseif ($httpCode == 404)
                          {
                          }
                        curl_close($handle);
                      }
                  }
                else
                  {
                    echo "\n File Not Found, Aborting Crawl ....\n";
                  }
              }
            else
              {
                goto csel;
              }
          }
      }
  }
?>
