<?php

namespace Backpack\Generators\Console\Commands\Views;

use Backpack\CRUD\ViewNamespaces;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

abstract class PublishOrCreateViewBackpackCommand extends GeneratorCommand
{
    use \Backpack\CRUD\app\Console\Commands\Traits\PrettyCommandOutput;

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/../../stubs/'.$this->stub;
    }

    /**
     * Execute the console command.
     *
     * @return bool|null
     */
    public function handle()
    {
        $name = Str::of($this->getNameInput());
        $path = Str::of($this->getPath($name));
        $pathRelative = $path->after(base_path())->replace('\\', '/')->trim('/');

        $this->infoBlock("Creating {$name->replace('_', ' ')->title()} {$this->type}");
        $this->progressBlock("Creating view <fg=blue>{$pathRelative}</>");

        if ($this->alreadyExists($name)) {
            $this->closeProgressBlock('Already existed', 'yellow');

            return false;
        }

        $source = null;
        if ($this->option('from')) {
            $from = $this->option('from');
            $namespaces = ViewNamespaces::getFor($this->viewNamespace);
            foreach ($namespaces as $namespace) {
                $viewPath = "$namespace.$from";
                if (view()->exists($viewPath)) {
                    $source = view($viewPath)->getPath();
                    break;
                }
            }

            // full or relative file path may be provided
            if (file_exists($from)) {
                $source = realpath($from);
            }
            // remove the first slash to make absolute paths relative in unix systems
            elseif (file_exists(substr($from, 1))) {
                $source = realpath(substr($from, 1));
            }

            if (! $source) {
                $this->errorProgressBlock();
                $this->note("$this->type '$from' does not exist!", 'red');
                $this->newLine();

                return false;
            }
        }

        $this->makeDirectory($path);

        if ($source) {
            $this->files->copy($source, $path);
        } else {
            $this->files->put($path, $this->buildClass($name));
        }

        $this->closeProgressBlock();
    }

    /**
     * Determine if the class already exists.
     *
     * @param  string  $name
     * @return bool
     */
    protected function alreadyExists($name)
    {
        return $this->files->exists($this->getPath($name));
    }

    /**
     * Get the destination class path.
     *
     * @param  string  $name
     * @return string
     */
    protected function getPath($name)
    {
        return resource_path("views/vendor/backpack/crud/{$this->viewNamespace}/$name.blade.php");
    }

    /**
     * Build the class with the given name.
     *
     * @param  string  $name
     * @return string
     */
    protected function buildClass($name)
    {
        $stub = $this->files->get($this->getStub());
        $stub = str_replace('dummy', $name, $stub);

        return $stub;
    }

    /**
     * Get the desired class name from the input.
     *
     * @return string
     */
    protected function getNameInput()
    {
        $name = Str::of($this->argument('name'));
        $from = Str::of($this->option('from'));

        if ($name->isEmpty() && $from->isEmpty()) {
            throw new \Exception('Not enough arguments (missing: "name" or "--from").');
        }

        // Name may come from the --from option
        if ($name->isEmpty()) {
            $name = $from->afterLast('/')->afterLast('\\');
        }

        return (string) $name->trim()->snake('_');
    }
}
