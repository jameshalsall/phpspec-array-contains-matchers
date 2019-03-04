#!/usr/bin/env bash

if [ "1" = "$PREFER_LOWEST" ]; then
    FLAGS="--prefer-lowest"
else
    FLAGS=""
fi

echo "composer update $FLAGS"
composer update $FLAGS
