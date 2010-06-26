Open Power Forms 2.1-dev
===========================

Open Power Forms is a form processing library for PHP 5.3. It is fully
integrated with Open Power Template and uses it as a rendering layer.

The project belongs to the Open Power Libs foundation.

Key concepts
------------

The key concept behind OPF is the form processing model. From the technical
point of view, a form and form fields are the same things, which allows us
to compose bigger forms from smaller ones and process much more advanced
layouts.

Open Power Template rendering layer lets us define the form layout in
the natural manner, by writing and editing ordinary HTML code instead of
massive object-oriented and hard-to-reconfigure helpers. At the same time,
it provides an easy code reusage and flexibility.

Roadmap
-------

As the library was not released yet, we decided that it can use PHP 5.3
namespaces from scratch. The conversion will start soon.

Currently we are testing the architecture in the MVC design pattern and
make the necessary fixes. In order to make the first release possible,
we must make some improvements to the validator/filter architecture, and
write some of them.

In the near future, the support for Web Forms 2.0 is planned.

Authors and license
-------------------

Open Power Template - Copyright (c) Invenzzia Group 2008-2010

The code was written by:

+ Tomasz "Zyx" Jedrzejewski - design, programming, documentation
+ Paweł Łuczkiewicz - programming
+ Jacek "eXtreme" Jedrzejewski - testing, minor improvements, debug console
+ Amadeusz "megaweb" Starzykiewicz - additional programming.

The library is available under the terms of [New BSD License](http://www.invenzzia.org/license/new-bsd).