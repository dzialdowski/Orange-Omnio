# Orange Omnio

Aplikacja służy do pomocy doradcom biznesowym Orange w paru kwestiach podzielonych na panele.

Napisane z wykorzystaniem [Orange Boosted](https://boosted.orange.com/) - forka Bootstrapa 

## Kupony rabatowe

Konsultant widzi na bieżąco ilość dostępnych kuponów (odświeżane co 10s) wraz z opisem. Po kliknięciu przycisku "Biorę!" konsultant pobiera kupon, a sam kupon zostaje oznaczony w bazie jako zużyty. 
Doradca ma możliwość zwrotu kuponu w przypadku gdy jednak go nie wykorzysta (klient zadłużony, rozmyślił się, skończyły się urządzenia na stanie). Zwrot nie dodaje kolejnego kuponu do bazy, tylko odznacza w bazie zużycie kuponu, dzięki czemu nie obaw, że ktoś doda do aplikacji nieprawidłowe kody.

W przypadku gdy doradca zgubi kupon, aplikacja pamięta ten ostatnio pobrany, a jeżeli pobierze ich więcej to administrator ma interaktywne logi, które dają możliwość łatwego przywrócenia kuponu do bazy.

![image](https://user-images.githubusercontent.com/5255207/147415981-e933f4c0-e03f-4175-a72a-43027bda5abf.png)


## Kalkulator MNP

Prosty modal mający na celu podać przybliżoną datę przeniesienia numeru, zawiera też szczególne przypadki, które należy uwzględnić przy przenoszeniu numeru.

![image](https://user-images.githubusercontent.com/5255207/147416021-0586ff13-2c8d-42e9-8338-5c634b14925f.png)


## Terminale

Wyszukiwarka urządzeń w aplikacji z sieci korporacyjnej działa jak krew z nosa. Ta zakładka znacząco przyspiesza wyszukiwanie urządzeń, a względem standardowej wyszukiwarki z orange.pl dodaje 2 funkcje:

- W ogóle panel wyszukiwania, standardowo dostęp do niego mają wyłącznie konsultanci, a klienci muszą filtrować
- Stan magazynowy

![image](https://user-images.githubusercontent.com/5255207/147416045-453f75ab-86c0-4fee-9d1e-eacc26f6e555.png)


## Kody pocztowe 

Klienci często mają nieaktualne dane w systemach, a sami nie znają prawidłowego kodu pocztowego. Omnio pozwala wyszukać te kody pocztowe, które przepuści system korporacyjny.

### Weryfikacja FIX
Możliwość sprawdzenia możliwości technicznych na Internet pod wskazanym adresem.

## Admin panel
Panel do zarządzania aplikacją, możliwość logowania przez konto Telegram. Panel pojawi się na pasku nawigacyjnym tylko gdy administrator jest już zalogowany. Jeżeli nie jest, to musi ręcznie wejść na /login.php
### MOTD
Możliwość zamieszczenia jakiejś drobnej notatki dla pracowników. 4 typy wiadomości oraz jej podgląd.
### Dostępne kody
Dokładnie ten sam panel co w pierwszej zakładce. 
### Dodawanie kuponów
Hurtowe dodawanie kuponów. Należy wybrać typ kuponu, po czym wkleić listę kuponów oddzielonych spacją lub znakiem nowej linii.
### Pozostałe funkcje
Wyświetlanie i usuwanie(WIP) kuponów z bazy.

## Interaktywne logi
Każda interakcja z bazą danych jest wysyłana na kanał Telegram:

![image](https://user-images.githubusercontent.com/5255207/147415911-a9758b42-3795-48ee-917a-2bf31b938005.png)

# Instalacja

Aplikacja wymaga Microsoft SQL Server z powodu wykorzystywania funkcji `OUTPUT inserted.*` do pobierania kuponów rabatowych. 

Zarówno PHP 7 jak i PHP 8 będą działać.

Typy kuponów na ten moment dodaje się ręcznie.

## Plik `config.php`:
```
<?php
$con= // PDO sqlrv

$botKey= // klucz API do bota w formacie botxxxxxxxxxx:xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

$adminArray=array( // ID użytkowników Telegrama, którzy powinni mieć uprawnienia administracyjne
"000000000",  #Przykład 1
"111111111"   #Przykład 2
);

$logChannelID='-1001661365587'; // ID kanału do logów

$botUsername='omnio_testing_bot'; // Nazwa użytkownika bota

$endpoint="https://example.com/"; // URL aplikacji
```
## SQL

### Tabela `CouponsDev`
```
SET  ANSI_NULLS  ON
GO
SET  QUOTED_IDENTIFIER  ON
GO
CREATE  TABLE [dbo].[CouponsDev](
[couponID] [int] IDENTITY(1,1) NOT  NULL,
[couponType] [varchar](3) NOT  NULL,
[coupon] [varchar](18) NOT  NULL,
[isCouponUsed] [bit] NOT  NULL
) ON [PRIMARY]
GO
ALTER  TABLE [dbo].[CouponsDev] ADD  CONSTRAINT [PK_CouponsDev] PRIMARY  KEY  CLUSTERED
(
[couponID] ASC
)WITH (STATISTICS_NORECOMPUTE  =  OFF, IGNORE_DUP_KEY  =  OFF, ONLINE  =  OFF, OPTIMIZE_FOR_SEQUENTIAL_KEY =  OFF) ON [PRIMARY]
GO
SET  ANSI_PADDING  ON
GO
ALTER  TABLE [dbo].[CouponsDev] ADD  UNIQUE  NONCLUSTERED
(
[coupon] ASC
)WITH (STATISTICS_NORECOMPUTE  =  OFF, IGNORE_DUP_KEY  =  OFF, ONLINE  =  OFF, OPTIMIZE_FOR_SEQUENTIAL_KEY =  OFF) ON [PRIMARY]
GO
ALTER  TABLE [dbo].[CouponsDev] ADD  CONSTRAINT [DF_Coupons_isCouponUsedDev] DEFAULT ((0)) FOR [isCouponUsed]
GO
ALTER  TABLE [dbo].[CouponsDev] WITH  CHECK  ADD  CONSTRAINT [FK_Coupons_CouponTypeDev] FOREIGN KEY([couponType])
REFERENCES [dbo].[CouponType] ([CouponType])
GO
ALTER  TABLE [dbo].[CouponsDev] CHECK  CONSTRAINT [FK_Coupons_CouponTypeDev]
GO
```
### Tabela `CouponTypeDev`

```
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[CouponTypeDev](
	[CouponType] [varchar](3) NOT NULL,
	[CouponDesc] [varchar](300) NULL,
	[isActive] [bit] NULL
) ON [PRIMARY]
GO
SET ANSI_PADDING ON
GO
ALTER TABLE [dbo].[CouponTypeDev] ADD  CONSTRAINT [PK_CouponTypeDev] PRIMARY KEY CLUSTERED 
(
	[CouponType] ASC
)WITH (STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ONLINE = OFF, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
GO
ALTER TABLE [dbo].[CouponTypeDev]  WITH CHECK ADD  CONSTRAINT [FK_CouponType_CouponTypeDev] FOREIGN KEY([CouponType])
REFERENCES [dbo].[CouponTypeDev] ([CouponType])
GO
ALTER TABLE [dbo].[CouponTypeDev] CHECK CONSTRAINT [FK_CouponType_CouponTypeDev]
GO
```
