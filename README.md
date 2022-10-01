<p align="center">

[![Version][version-shield]][version]
[![Contributors][contributors-shield]][contributors-url]
[![Forks][forks-shield]][forks-url]
[![Stargazers][stars-shield]][stars-url]
[![Issues][issues-shield]][issues-url]
[![MIT License][license-shield]][license-url]

</p>

<br />

<h2 align="center">value-object</h3>
<p align="center">
    Collection of ValueObject ready to use on DDD projects with Symfony validator integrated 
    <br /><br />
    <a href="https://www.php.net/"><img src="https://img.shields.io/badge/PHP-8.1-777BB4.svg?style=flat-square&logo=php" alt="PHP"/></a>
    <br /><br />
    <a href="https://github.com/masfernandez/value-object/issues">Report Bug</a>
    ·
    <a href="https://github.com/masfernandez/value-object/issues">Request Feature</a>
</p>

<br />

[![Build Status](https://api.travis-ci.com/masfernandez/value-object.svg?branch=master)](https://app.travis-ci.com/github/masfernandez/value-object)
[![Coverage Status](https://coveralls.io/repos/github/masfernandez/value-object/badge.svg?branch=88cc78f)](https://coveralls.io/github/masfernandez/value-object?branch=88cc78f)

<br />

<details open="open">
  <summary>Table of Contents</summary>
  <ol>
    <li>
      <a href="#about-the-project">About The Project</a>
    </li>
    <li>
      <a href="#getting-started">Getting Started</a>
      <ul>
        <li><a href="#prerequisites">Prerequisites</a></li>
        <li><a href="#installation">Installation</a></li>
        <li><a href="#examples">Examples</a></li>
      </ul>
    </li>
    <li><a href="#roadmap">Roadmap</a></li>
    <li><a href="#contributing">Contributing</a></li>
    <li><a href="#license">License</a></li>
    <li><a href="#contact">Contact</a></li>
    <li><a href="#acknowledgements">Acknowledgements</a></li>
  </ol>
</details>

## About The Project

I have created this collection of ValueObjects to use in the projects I am working on.  

**ValueObjects types**

- [x] String
- [x] Nullable string
- [x] Uuid
- [x] Nullable uuid
- [x] Mixed
- [x] Int
- [x] Nullable int
- [x] Float
- [x] Nullable float
- [x] DateTime `Y-m-d\TH:i:sP`
- [x] DateTime milliseconds `Y-m-d\TH:i:s.uP`
- [x] Coordinate (x float, y float)


## Getting Started


### Prerequisites
N/A

### Installation

```bash
composer require masfernandez/value-object
```

### Examples

Value object modeling a book title. It enforces a string primitive type, not blank by default on StringValueObject. 

```php
<?php

declare(strict_types=1);

namespace My\Awesome\Ddd\Project;

use Masfernandez\ValueObject\StringValueObject;

final class BookTitle extends StringValueObject
{
}
```

```php
$bookTitle = new BookTitle('Implementing Domain-Driven Design');
echo $bookTitle->value();
echo $bookTitle;
```

```bash
# output

$ Implementing Domain-Driven Design
$ Implementing Domain-Driven Design
```

Wrong book title: can not be blank

```php
$bookTitle = new BookTitle('');

'This value is too short. It should have 1 character or more.'
```


Value object modeling a user email. It enforces a string primitive type, not blank by default on StringValueObject, and add some additional constraints: email format and a max length of 255

```php
<?php

declare(strict_types=1);

namespace My\Awesome\Ddd\Project;

use Masfernandez\ValueObject\StringValueObject;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints;

final class UserEmail extends StringValueObject
{
    /**
     * @return Constraint[]
     */
    protected static function setConstraints(): array
    {
        return array_merge(
            parent::setConstraints(),
            [
                new Constraints\Email(),
                new Constraints\Length(['max' => 255]),
            ]
        );
    }
}
```

```php
$userEmail = new UserEmail('mangel.sanfer@gmail.com');
echo $userEmail->value();
echo $userEmail;
```

```bash
# output

$ mangel.sanfer@gmail.com
$ mangel.sanfer@gmail.com
```

## Roadmap

See the [open issues](https://github.com/masfernandez/value-object/issues) for a list of proposed features (and known issues).


## Contributing

Contributions are what make the open source community such an amazing place to be learn, inspire, and create. Any contributions you make are **greatly appreciated**.

1. Fork the Project
2. Create your Feature Branch (`git checkout -b feature/AmazingFeature`)
3. Commit your Changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the Branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request


## License

Distributed under the MIT License. See `LICENSE.txt` for more information.


## Contact

Miguel Ángel Sánchez Fernández - mangel.sanfer@gmail.com

(linkedin hiden profile - require login)

[![LinkedIn][linkedin-shield]][linkedin-url]

Project Link: [https://github.com/masfernandez/value-object](https://github.com/masfernandez/value-object)


## Acknowledgements

* README template based on: [https://github.com/othneildrew/Best-README-Template](https://github.com/othneildrew/Best-README-Template)
* CHANGELOG template based on: [https://keepachangelog.com/en/1.0.0/](https://keepachangelog.com/en/1.0.0/)

## Stats

<p>
    <img src="https://views.whatilearened.today/views/github/masfernandez/views.svg"/>
</p>

[version-shield]: https://img.shields.io/github/v/tag/masfernandez/value-object?style=for-the-badge
[version]: https://github.com/masfernandez/value-object/tags

[contributors-shield]: https://img.shields.io/github/contributors/masfernandez/value-object.svg?style=for-the-badge
[contributors-url]: https://github.com/masfernandez/value-object/graphs/contributors

[forks-shield]: https://img.shields.io/github/forks/masfernandez/value-object.svg?style=for-the-badge
[forks-url]: https://github.com/masfernandez/value-object/network/members

[stars-shield]: https://img.shields.io/github/stars/masfernandez/value-object.svg?style=for-the-badge
[stars-url]: https://github.com/masfernandez/value-object/stargazers

[issues-shield]: https://img.shields.io/github/issues/masfernandez/value-object.svg?style=for-the-badge
[issues-url]: https://github.com/masfernandez/value-object/issues

[license-shield]: https://img.shields.io/github/license/masfernandez/value-object.svg?style=for-the-badge
[license-url]: https://github.com/masfernandez/value-object/blob/master/LICENSE.txt

[linkedin-shield]: https://img.shields.io/badge/-LinkedIn-black.svg?style=for-the-badge&logo=linkedin&colorB=555
[linkedin-url]: https://linkedin.com/in/masfernandez