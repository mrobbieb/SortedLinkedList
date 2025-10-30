# 🧩 SortedLinkedList

A simple **sorted singly-linked-list** implementation in **PHP 8 / Symfony 7**, providing both a clean data structure API and interactive console commands for experimenting with list operations.

---

## 📚 Table of Contents

- [Overview](#-overview)
- [Features](#-features)
- [Requirements](#-requirements)
- [Installation](#-installation)
- [Running the App](#-running-the-app)
  - [Using the Symfony Console](#using-the-symfony-console)
  - [Using the Built-in Web Server](#using-the-built-in-web-server)
- [Example Commands](#-example-commands)
- [Testing](#-testing)
- [Project Structure](#-project-structure)
- [Contributing](#-contributing)
- [License](#-license)

---

## 🧠 Overview

`SortedLinkedList` is a small educational and utility package that demonstrates how to build, sort, and interact with a **singly linked list** in PHP — complete with **sorted insertion**, **deletion**, and **interactive CLI editing** using Symfony’s Console component.

---

## ✨ Features

- Maintains **sorted order** on insertion.
- Supports **add**, **remove**, **insert, and **show** operations.
- Interactive **Symfony Console command** (`app:sorted-linked-list`) for experimentation.
- Includes **unit tests** for list behavior.
- Extensible and PSR-compliant structure.

---

## ⚙️ Requirements

| Dependency | Version |
|-------------|----------|
| PHP | ≥ 8.1 |
| Composer | ≥ 2.5 |
| Symfony | ≥ 7.0 |
| ext-mbstring, ext-json | Enabled |

---

## 🧰 Installation

Clone the repository and install dependencies:

```bash
git clone https://github.com/mrobbieb/SortedLinkedList.git
cd SortedLinkedList
composer install
```

If Symfony CLI is installed, you can verify setup:

```bash
symfony check:requirements
```

---

## ▶️ Running the App

### Using the Symfony Console

The project includes an interactive command to manage a sorted linked list.

Run:

```bash
php bin/console app:sorted-linked-list
```

You’ll enter an interactive shell with commands like:

```
Enter a command - add/remove/set/show/order/help/exit
```

## 🧩 Example Commands

Below are examples using the interactive console.

## Add a new list
```
> set 1,2,3
```

### Add a value
```
> add apple
Added: apple
```

### Add another (keeps order)
```
> add banana
[apple, banana]
```

### Remove a value
```
> remove carrot
[apple, banana]
```

### Display list
```
> show
[apple, banana]
```

### Exit
```
> exit
Goodbye!
```

---

## 🧪 Testing

Run unit tests (if configured under `/tests`):

```bash
./vendor/bin/phpunit
```

Or, if using Symfony’s test setup:

```bash
php bin/phpunit
```

---

## 🗂 Project Structure

```
SortedLinkedList/
├── src/
│   ├── Command/
│   │   └── SortedLinkedListCommand.php
│   ├── LinkedList/
│   │   ├── LinkedList.php
│   │   └── Node.php
│   └── ...
├── tests/
│   └── LinkedListTest.php
├── bin/
│   └── console
├── composer.json
└── README.md
```

---

## Libraries
    - https://github.com/JethroT83/SortedLinkedList
    

## API 
I started using an API with sqLite but abanonded the idea. But you can get a general idea of what i was building...

```bash
symfony serve
# or
php -S 127.0.0.1:8000 -t public
```

Visit: [http://127.0.0.1:8000](http://127.0.0.1:8000)

```bash
curl -X GET https://127.0.0.1:8000/api/sll/get
```

or

```bash
curl -X POST https://127.0.0.1:8000/api/sll/create -H "Content-Type: application/json" -d '
{
"type": "string",    
"order": "desc",
"list": ["apple","banana","orange"
}'
```

---

## 📜 License

This project is licensed under the **MIT License**.  
See the [LICENSE](LICENSE) file for more information.

---

**Author:** [Martin Baker](https://github.com/mrobbieb)  
**Repo:** [https://github.com/mrobbieb/SortedLinkedList](https://github.com/mrobbieb/SortedLinkedList)

---
