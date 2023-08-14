<?php

interface ValidatorInterface
{
    public static function validate(mixed $value): bool;
}