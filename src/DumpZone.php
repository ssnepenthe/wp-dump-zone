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
    private static $renderHook = 'wp_footer';
    private static $renderHookPriority = 999;

    public static function getDumpCount(): int
    {
        return static::$dumpCount;
    }

    public static function setRenderHook(string $renderHook)
    {
        static::$renderHook = $renderHook;
    }

    public static function setRenderHookPriority(int $renderHookPriority)
    {
        static::$renderHookPriority = $renderHookPriority;
    }

    public static function dump($var)
    {
        if (! static::$registered) {
            \add_action(static::$renderHook, function () {
                include __DIR__ . '/dump-zone-template.php';
            }, static::$renderHookPriority);

            static::$registered = true;
        }

        static::$dumpCount++;

        $cloned = static::getCloner()->cloneVar($var);

        \add_action(__CLASS__, function () use ($cloned) {
            static::getDumper()->dump($cloned);
        });
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

    public static function getCloner(): ClonerInterface
    {
        if (! static::$cloner instanceof ClonerInterface) {
            static::$cloner = new VarCloner();
            static::$cloner->addCasters(ReflectionCaster::UNSET_CLOSURE_FILE_INFO);
        }

        return static::$cloner;
    }

    public static function setDumper(DataDumperInterface $dumper)
    {
        static::$dumper = $dumper;
    }

    public static function setCloner(ClonerInterface $cloner)
    {
        static::$cloner = $cloner;
    }
}
