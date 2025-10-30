<?php

namespace App\Tests\Command;

use App\Command\SortedLinkedListCommand;
use PHPUnit\Framework\Attributes\Test;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class SortedLinkedListCommandTest extends KernelTestCase
{
    #[Test]
    public function testExecute(): void
    {
        self::bootKernel();

        // Build a throwaway console app for the test
        $application = new Application(self::$kernel);
        $application->add(new SortedLinkedListCommand());

        $command = $application->find('app:sorted-linked-list-old');
        $tester  = new CommandTester($command);

        // Simulate the user's answers to "Enter a command - add/remove/set/show/help/exit"
        $tester->setInputs([
            'show',
            'add apple',
            'add banana',
            'add 1',
            'remove banana',
            'set 3,1,2',
            'set 3,1,foo',
            'exit',
        ]);

        // Run interactively (no args/options for this command)
        $exitCode = $tester->execute([], ['interactive' => true]);

        $display = $tester->getDisplay();

        // Basic sanity checks on the interactive flow
        $this->assertSame(0, $exitCode, 'Command should exit with SUCCESS.');
        $this->assertStringContainsString('Sorted Linked List Command', $display);
        $this->assertStringContainsString('Commands', $display);                    // help printed at start
        $this->assertStringContainsString('Current list (sorted)', $display);       // initial show section
        $this->assertStringContainsString('[empty]', $display);                     // initial list is empty

        // After "add apple"
        $this->assertStringContainsString('Added "apple" (sorted).', $display);
        $this->assertStringContainsString('["apple"]', $display);

        // After "add banana"
        $this->assertStringContainsString('Added "banana" (sorted).', $display);
        $this->assertStringContainsString('["apple","banana"]', $display);

        // // After "add 1"
        $this->assertStringContainsString('Invalid datatype:1', $display);
        $this->assertStringContainsString('["apple","banana"]', $display);

        // After "remove banana"
        $this->assertStringContainsString('Removed "banana" (if present).', $display);
        $this->assertStringContainsString('["apple"]', $display);

        // After "set 3,1,2" (should be sorted to [1,2,3])
        $this->assertStringContainsString('List overwritten (sorted).', $display);
        $this->assertStringContainsString('[1,2,3]', $display);

        // After "set 3,1,foo" (should be sorted to [1,2])
        $this->assertStringContainsString('Invalid datatype:1', $display);
        $this->assertStringContainsString('List overwritten (sorted).', $display);
        $this->assertStringContainsString('[1,3]', $display);

        // Final "exit"
        $this->assertStringContainsString('exit', $display);
    }
}
