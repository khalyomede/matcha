<?php
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
                static::TYPE_STRING
            ];
        }
    }
?>