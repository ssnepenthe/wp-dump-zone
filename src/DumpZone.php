<?php

namespace DumpZone;

use Symfony\Component\VarDumper\Caster\ReflectionCaster;
use Symfony\Component\VarDumper\Cloner\ClonerInterface;
use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\ContextProvider\SourceContextProvider;
use Symfony\Component\VarDumper\Dumper\ContextualizedDumper;
use Symfony\Component\VarDumper\Dumper\DataDumperInterface;
use Symfony\Component\VarDumper\Dumper\HtmlDumper;

final class DumpZone
{
    private static $cloner;
    private static $dumpCount = 0;
    private static $dumper;
    private static $registered = false;
    private static $renderHooks = [
        ['admin_footer', 999],
        ['wp_footer', 999],
    ];

    public static function addRenderHook(string $hook, int $priority): void
    {
        static::$renderHooks[] = [$hook, $priority];
    }

    public static function dump($var): void
    {
        if (! static::$registered) {
            foreach (static::$renderHooks as [$hook, $priority]) {
                \add_action($hook, static function () {
                    include __DIR__ . '/dump-zone-template.php';
                }, $priority);
            }

            static::$registered = true;
        }

        static::$dumpCount++;

        $cloned = static::getCloner()->cloneVar($var);

        \add_action(__CLASS__, function () use ($cloned) {
            static::getDumper()->dump($cloned);
        });
    }

    public static function getCloner(): ClonerInterface
    {
        if (! static::$cloner instanceof ClonerInterface) {
            static::$cloner = new VarCloner();
            static::$cloner->addCasters(ReflectionCaster::UNSET_CLOSURE_FILE_INFO);
        }

        return static::$cloner;
    }

    public static function getDumpCount(): int
    {
        return static::$dumpCount;
    }

    public static function getDumper(): DataDumperInterface
    {
        if (! static::$dumper instanceof DataDumperInterface) {
            static::$dumper = new ContextualizedDumper(
                new HtmlDumper(),
                [new SourceContextProvider()]
            );
        }

        return static::$dumper;
    }

    public static function renderDumps(): void
    {
        \do_action(__CLASS__);
    }

    public static function setCloner(ClonerInterface $cloner): void
    {
        static::$cloner = $cloner;
    }

    public static function setDumper(DataDumperInterface $dumper): void
    {
        static::$dumper = $dumper;
    }

    public static function setRenderHooks(array $renderHooks): void
    {
        static::$renderHooks = [];

        foreach ($renderHooks as [$hook, $priority]) {
            static::addRenderHook($hook, $priority);
        }
    }
}
