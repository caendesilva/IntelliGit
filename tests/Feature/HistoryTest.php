<?php

test('history command can run', function () {
    $this->artisan('history')
        ->assertExitCode(0);
});
