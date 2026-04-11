<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# QueryDock

Interactive SQL practice platform integrated with Learning Management Systems through **LTI 1.3**.

## Overview

QueryDock is an interactive platform for teaching SQL in universities.

It integrates directly with Learning Management Systems through LTI 1.3 and allows students to write and execute SQL queries inside a safe environment.

Instructors can create exercises, automatically grade submissions, and monitor student performance.

## Why QueryDock?

Teaching SQL often involves manual grading and static exercises.

This creates several problems:

- slow feedback for students
- heavy grading workload for instructors
- lack of interactive learning environments

QueryDock solves this by providing automated grading and isolated query execution environments integrated with LMS platforms.

## Features (to be added in the future)

### Student Experience

- SQL editor in the browser
- query execution with instant feedback
- schema visualization
- multiple attempts

### Instructor Tools

- activity creation
- automatic grading
- submission review
- class analytics dashboard

### Platform

- LTI 1.3 authentication
- automatic grade return to LMS
- secure query execution

## Architecture

QueryDock consists of the following components:

Frontend
- Svelte application through SSR
- SQL editor using Monaco

Backend
- Laravel API
- LTI integration layer
- grading engine

Execution Engine
- isolated PostgreSQL instances
- Docker-based sandbox

Infrastructure
- Docker containers
- No-setup web app through a Coolify hosted server


# Quick Start
Clone the repository:

```bash
git clone https://github.com/Matheus-Felipe-C/sql-editor/tree/main
cd querydock
docker-compose up
```

## Tech Stack
Backend
- [Laravel](https://github.com/laravel/laravel)
- [Laravel Celtic LTI](https://github.com/longhornopen/laravel-celtic-lti?tab=readme-ov-file)

Frontend
- [Svelte](https://github.com/sveltejs/svelte)
- [CodeMirror](https://codemirror.net/)

Database
- [PostgreSQL](https://github.com/postgres/postgres)

Infrastructure
- [Docker](https://www.docker.com/)

## Roadmap
MVP
- [x] LTI authentication
- [ ] SQL editor
- [ ] query execution
- [ ] automatic grading

Future
- query evolution tracking
- error analysis
- advanced analytics
- multi-language runtimes

## Contributing

Contributions will not be accepted until October 31st, to guarantee my safety to defend my thesis.

## License
This project is open-sourced software licensed under the [AGPL v3 license](https://opensource.org/license/agpl-3-0).