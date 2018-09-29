<?php
    /*
    MIT License

    Copyright (c) 2018 Khalyomede

    Permission is hereby granted, free of charge, to any person obtaining a copy
    of this software and associated documentation files (the "Software"), to deal
    in the Software without restriction, including without limitation the rights
    to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
    copies of the Software, and to permit persons to whom the Software is
    furnished to do so, subject to the following conditions:

    The above copyright notice and this permission notice shall be included in all
    copies or substantial portions of the Software.

    THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
    IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
    FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
    AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
    LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
    OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
    SOFTWARE.
    */
    
    namespace Khalyomede;

    class TestType {
        const SAME_VALUE = 1;
        const SAME_EXCEPTION = 2;
        const SAME_EXCEPTION_MESSAGE = 3;
        const INSTANCE_OF = 4;
        const NULLITY = 5;
        const TYPE_RESOURCE = 6;
        const VALUE_TRUE = 7;
        const TYPE_STRING = 8;
        const TYPE_ARRAY = 9;
        const VALUE_FALSE = 10;
        const TYPE_INTEGER = 11;
        const TYPE_FLOAT = 12;
        const TYPE_DOUBLE = 13;
        const TYPE_FUNCTION = 14;
        const DISPLAYED_MESSAGE = 15;
        const TYPE_BOOLEAN = 16;
        const TYPE_OBJECT = 17;
        const FORMAT_JSON = 18;

        public static function correct(int $type): bool {
            return in_array($type, static::availableTypes) === true;
        }

        protected static function availableTypes(): array {
            return [
                static::SAME_VALUE,
                static::SAME_EXCEPTION,
                static::SAME_EXCEPTION_MESSAGE,
                static::INSTANCE_OF,
                static::NULLITY,
                static::TYPE_RESOURCE,
                static::VALUE_TRUE,
                static::TYPE_STRING,
                static::TYPE_ARRAY,
                static::VALUE_FALSE,
                static::TYPE_INTEGER,
                static::TYPE_FLOAT,
                static::TYPE_DOUBLE,
                static::TYPE_FUNCTION,
                static::DISPLAYED_MESSAGE,
                static::TYPE_BOOLEAN,
                static::TYPE_OBJECT,
                static::FORMAT_JSON
            ];
        }
    }
?>