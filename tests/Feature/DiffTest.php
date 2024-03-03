<?php

test('diff command can run', function () {
    $this->artisan('diff')
         ->assertExitCode(0);
});
