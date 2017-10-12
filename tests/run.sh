#!/bin/bash
set -e

echo "Starting tests" >&1

docker-compose run --rm -e "KBC_DATADIR=/code/tests/data-simple/" dev
if diff --brief --recursive ./tests/data-simple/out/tables/ ./tests/data-simple/out/sample-tables/ ; then
    printf "Case simple successful.\n"
else
    printf "Case simple failed.\n"
    diff --recursive ./tests/data-simple/out/tables/ ./tests/data-simple/out/sample-tables/
fi

docker-compose run --rm -e "KBC_DATADIR=/code/tests/data-header/" -e "KBC_PARAMETER_COLUMN_NAME=rownum" dev
if diff --brief --recursive ./tests/data-header/out/tables/ ./tests/data-header/out/sample-tables/ ; then
    printf "Case header successful.\n"
else
    printf "Case header failed.\n"
    diff --recursive ./tests/data-header/out/tables/ ./tests/data-header/out/sample-tables/
fi

docker-compose run --rm -e "KBC_DATADIR=/code/tests/data-sliced/" dev
if diff --brief --recursive ./tests/data-sliced/out/tables/ ./tests/data-sliced/out/sample-tables/ ; then
    printf "Case sliced successful.\n"
else
    printf "Case sliced failed.\n"
    diff --recursive ./tests/data-sliced/out/tables/ ./tests/data-sliced/out/sample-tables/
fi

docker-compose run --rm -e "KBC_DATADIR=/code/tests/data-csvparams/" -e "KBC_PARAMETER_DELIMITER=	" -e "KBC_PARAMETER_ENCLOSURE='" dev
if diff --brief --recursive ./tests/data-csvparams/out/tables/ ./tests/data-csvparams/out/sample-tables/ ; then
    printf "Case csvparams successful.\n"
else
    printf "Case csvparams failed.\n"
    diff --recursive ./tests/data-csvparams/out/tables/ ./tests/data-csvparams/out/sample-tables/
fi
