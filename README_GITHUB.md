О, давай усе розкладемо по поличках, як DevOps-бібліотеку 📚
Ти отримаєш повністю **готову структуру**, яку можна просто скопіпастити, і воно **буде працювати**.

---

## 🔧 **1. Що ми робимо?**

Ми налаштовуємо **CI/CD з GitHub Actions**, який:

- Деплоїть твій WordPress сайт з репозиторію
- Робить **бекап**
- При фейлі — **робить rollback**
- Веде **лог** деплоїв
- Надсилає **повідомлення в Telegram**

---

## 📁 **2. Структура твого GitHub репозиторію**

У корені проєкту має бути:

```
your-wp-project/
├── .github/
│   └── workflows/
│       └── deploy.yml     ← наш GitHub Actions скрипт
├── .env                   ← твій .env файл (локально, не пуш у публічний репозиторій!)
├── wp-content/
│   └── themes/
│   └── plugins/
└── (інші WP файли)
```

---

## 📄 **3. Створи файл GitHub Actions**

### 📍 Шлях

```
.github/workflows/deploy.yml
```

### 🧾 Вміст

Скопіюй туди повну версію `deploy.yml`, яку я тобі надав вище з:

- автологуванням
- ротацією
- Telegram нотифікаціями
- rollback при фейлі

💬 *Хочеш — можу згенерити готовий файл у вигляді завантаження, скажеш тільки.*

---

## 🔑 **4. Додай секрети на GitHub**

Перейди в репозиторії:
**Settings → Secrets and variables → Actions → New repository secret**

Додай отакі:

| Назва                    | Що це                                         |
|--------------------------|-----------------------------------------------|
| `DEPLOY_USER`            | Наприклад: `vit`                              |
| `DEPLOY_HOST`            | IP або домен твого домашнього сервера         |
| `DEPLOY_PATH`            | `/var/www/wordpress` або інше                 |
| `SSH_PRIVATE_KEY`        | Приватний ключ для SSH (генеруєш вручну)      |
| `TELEGRAM_BOT_TOKEN`     | Отримуєш у @BotFather                          |
| `TELEGRAM_CHAT_ID`       | Chat ID (можу допомогти знайти)               |

---

## 🖥️ **5. На домашньому сервері Ubuntu**

🔧 **Підготуй середовище**

1. Створи шлях для сайту:

```bash
sudo mkdir -p /var/www/wordpress
sudo chown -R vit:www-data /var/www/wordpress
```

2. Додай **публічний ключ**, який відповідає приватному `SSH_PRIVATE_KEY`, в:

```bash
/home/vit/.ssh/authorized_keys
```

3. Переконайся, що встановлено:

```bash
sudo apt install -y rsync curl php-cli unzip
```

4. Встанови WP-CLI (якщо ще ні):

```bash
curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar
chmod +x wp-cli.phar
sudo mv wp-cli.phar /usr/local/bin/wp
```

5. Створи директорію для бекапів:

```bash
mkdir -p ~/releases
```

---

## ✅ **6. Перевір, чи все працює**

- Пуш у гілку `main` → запускається GitHub Actions
- Telegram повідомляє про успіх або rollback
- `~/deploy.log` заповнюється на сервері
- `~/releases/` зберігає останні 5 бекапів

---

## 🚀 **Все готово до старту!**

Хочеш, я згенерую повністю готовий `deploy.yml` ще раз, з усім, що ми допиляли, одним шматком?
Або зробити скрипт з сервера, який показує останній деплой?
