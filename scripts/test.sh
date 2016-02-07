#!/usr/bin/env bash

# Enter project root
cd ..

# Deploy as...
SU='sudo -EHu www-data'

$SU git checkout develop
$SU phing test-update
$SU phing test-run-static-analysis
$SU phing test-regenerate-fixtures
$SU phing test-run-tests

# Releasing stable code from develop to master
$SU git push origin develop:master
