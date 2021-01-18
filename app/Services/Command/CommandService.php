<?php
namespace App\Services\Command;

use App\Repositories\RoverRepository\RoverRepositoryInterface;
use App\Repositories\PlanetRepository\PlanetRepositoryInterface;
use App\Exceptions\Command\IssueFoundException;

class CommandService
{
    protected $forwardDirection;
    protected $report;
    protected $rawCommands;
    protected $parsedCommands;
    protected $foundIssue = false;

    protected $orientations = [
        'n' => 'North',
        'e' => 'East',
        's' => 'South',
        'w' => 'West',
    ];

    public function __construct(RoverRepositoryInterface $roverRepository, PlanetRepositoryInterface $planetRepository) {
        $this->roverRepository = $roverRepository;
        $this->planetRepository = $planetRepository;
    }

    /**
     * SETTERS & GETTERS
     */
    public function getRawCommands(): string {
        return $this->rawCommands;
    }

    public function setRawCommands(string $value): void {
        $this->rawCommands = strtolower($value);
    }

    public function getParsedCommands(): array {
        return $this->parsedCommands;
    }

    public function getRequiredDirection(): string {
        return $this->roverRepository->getOrientation();
    }

    public function setOrientation(string $value): void {
        $this->roverRepository->setOrientation($value);
    }

    public function setParsedCommands(array $commands): void {
        $this->parsedCommands = $commands;
    }

    public function setIssue(IssueFoundException $exception): void {
        $this->setReport($exception->getMessage());
        $this->setFoundIssue(true);
    }

    public function setForwardDirection(): void {
        $direction = $this->getRequiredDirection();

        if($direction == 'e' || $direction == 'w') {
            $this->forwardDirection = 'x';
        } else {
            $this->forwardDirection = 'y';
        }
    }
    
    public function getForwardDirection(): string {
        return $this->forwardDirection;
    }

    public function getReport(): string {
        return $this->report;
    }

    public function setReport(string $value): void {
        $this->report = $value;
    }

    public function setFoundIssue(bool $value): void  {
        $this->foundIssue = $value;
    }

    public function getFoundIssue(): bool {
        return $this->foundIssue;
    }

    public function getOrientationNameByKey(string $key): string {
        return $this->orientations[$key];
    }
    
    /**
     * ACTIONS
     */
    public function readInput(string $commands): CommandService {
        $this->start($commands);
        return $this;
    }

    public function getOutput(): string {
        return $this->getReport();
    }

    public function wasEverythingOK(): bool {
        return $this->getFoundIssue() === false;
    }

    public function parseCommands(): void {
        $commands = [];

        foreach(str_split($this->getRawCommands()) as $command) {
            array_push($commands, $command);
        }

        $this->setParsedCommands($commands);
    }

    public function start(string $commands): void {
        $this->setRawCommands($commands);
        $this->parseCommands();

        try {
            $this->drive();
        } catch(IssueFoundException $e) {
            $this->setIssue($e);
        }
    }

    public function drive(): void {
        $this->setForwardDirection();

        foreach ($this->getParsedCommands() as $command) {
            $this->move($command);
        }

        $this->endDrive();
    }    

    public function endDrive(): void {
        $x = $this->roverRepository->getX();
        $y = $this->roverRepository->getY();
        $direction = $this->getOrientationNameByKey($this->getRequiredDirection());
        
        $success = "My actual coords are x: {$x} y: {$y} | My orientation: {$direction}";
        $this->setReport($success);
    }

    public function move(string $command): void {
        if($command == "l") {
            $this->turnLeft();
        }

        if($command == "r") {
            $this->turnRight();
        }

        $this->goForward();
    }

    public function goForward(): void {
        $direction = $this->getForwardDirection();
        $roverX = $this->roverRepository->getX();
        $roverY = $this->roverRepository->getY();

        // TODO: We could avoid repeat that code
        if($direction == "x") {
            $this->forwardX($roverX, $this->getRequiredDirection());
        } else {
            $this->forwardY($roverY, $this->getRequiredDirection());
        }
    }

    public function forwardX(int $x, string $direction): void {
        $moveTo = $direction == 'w' ? $x-1 : $x+1;
        $planetWidth = $this->planetRepository->getWidth();

        if($moveTo >= 0 && $moveTo < $planetWidth) {
            $this->roverRepository->setX($moveTo);
        } else {
            $this->throwIssueFoundException($direction, $moveTo, $this->getForwardDirection());
        }   
    }

    public function forwardY(int $y, string $direction): void {
        $moveTo = $direction == 'n' ? $y-1 : $y+1;
        $planetHeight = $this->planetRepository->getHeight();

        if($moveTo >= 0 && $moveTo < $planetHeight) {
            $this->roverRepository->setY($moveTo);
        } else {
            $this->throwIssueFoundException($direction, $moveTo, $this->getForwardDirection());
        }
    }

    public function throwIssueFoundException(string $direction, int $moveTo, string $axis): void {
        $x = $this->roverRepository->getX();
        $y = $this->roverRepository->getY();
        $direction = $this->getOrientationNameByKey($this->getRequiredDirection());
        throw new IssueFoundException("Something went wrong | My orientation: {$direction} | My coords x: {$x} y: {$y} | I was trying to go to {$axis}: {$moveTo}");
    }

    public function turnRight(): void {
        $compass = $this->roverRepository->getCompass();
        $pos = array_shift($compass);
        array_push($compass, $pos);
        $this->endTurn($compass);
    }

    public function turnLeft(): void {
        $compass = $this->roverRepository->getCompass();
        $pos = array_pop($compass);
        array_unshift($compass, $pos);
        $this->endTurn($compass);
    }

    protected function endTurn(array $compass): void {
        $this->roverRepository->setCompass($compass);
        $this->setOrientation($this->roverRepository->getCompass()[0]);
        $this->setForwardDirection();
    }
}