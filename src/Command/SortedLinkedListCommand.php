<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use SortedLinkedList\LinkedList;
use Exception;

#[AsCommand(name: 'app:sorted-linked-list-old', description: 'Interactively edit a sorted linked list.')]
class SortedLinkedListCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        return $this->__invoke($input, $output);
    }
    public function __invoke(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $io->title('Sorted Linked List Command');
        $this->printHelp($io);

        $list = LinkedList::new();

        $this->printList($io, $list);

        while (true) {
            $line = $io->ask('Enter a command - add/remove/set/show/help/exit');

            if ($line === null) {
                $this->printHelp($io);
                continue;
            }

            $cmd = trim($line);

            // Exit
            if (strcasecmp($cmd, 'exit') === 0) {
                $io->success('exit');
                return Command::SUCCESS;
                //break;
            }

            // Help
            if (strcasecmp($cmd, 'help') === 0) {
                $this->printHelp($io);
                continue;
            }

            // Show
            if (strcasecmp($cmd, 'show') === 0) {
                $this->printList($io, $list);
                continue;
            }

            if (preg_match('/^add\s+(.+)$/i', $cmd, $m)) {
                $value = trim($m[1]);

                $value = is_numeric($value) ? intval($value) : $value;

                if ($value === '') {
                    $io->warning('Provide a value: e.g., "add apple".');
                    continue;
                }

                $value = is_numeric($value) ? intval($value) : $value;
                try {
                    $list->add($value);
                    $io->success(sprintf('Added "%s" (sorted).', $value));
                } catch (Exception $e) {
                    $io->error($e->getMessage() . ":" . $value);
                }

                $this->printList($io, $list);
                continue;
            }

            // remove <value>
            if (preg_match('/^remove\s+(.+)$/i', $cmd, $m)) {
                $value = trim($m[1]);

                $value = is_numeric($value) ? intval($value) : $value;

                if ($value === '') {
                    $io->warning('Provide a value: e.g., "remove apple".');
                    continue;
                }
                $list->remove($value); // assume no-op if missing
                $io->success(sprintf('Removed "%s" (if present).', $value));
                $this->printList($io, $list);
                continue;
            }

            // set a,b,c
            if (preg_match('/^set\s+(.+)$/i', $cmd, $m)) {
                $list = LinkedList::new();
                $csv = trim($m[1]);
                $items = array_filter(array_map('trim', explode(',', $csv)), static fn($v) => $v !== '');

                foreach ($items as $value) {
                    $value = is_numeric($value) ? intval($value) : $value;
                    try {
                        $list->add($value);
                    } catch (Exception $e) {
                        $io->error($e->getMessage() . ':' . $value);
                    }
                }

                $io->success('List overwritten (sorted).');
                $this->printList($io, $list);
                continue;
            }
            $io->warning('Unrecognized command. Type "help" to see options.');
        }
    }

    private function printHelp(SymfonyStyle $io): void
    {
        $io->section('Commands');
        $io->listing([
            'add <value>           - Add a value (keeps list sorted)',
            'remove <value>        - Remove a value (if present)',
            'set a,b,c             - Overwrite the list (sorted)',
            'show                  - Display the current list',
            'help                  - help',
            'exit                  - exit',
        ]);
    }

    private function printList(SymfonyStyle $io, LinkedList $list): void
    {
        $io->section('Current list (sorted)');
        $arr = $list->toArray();
        $io->writeln($arr === [] ? '[empty]' : json_encode($arr));
    }
}
