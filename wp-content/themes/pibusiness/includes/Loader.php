<?php

namespace App;

/**
 * Class Loader
 */
class Loader
{

    /**
     * @var array
     */
    protected $actions = [];

    /**
     * @var array
     */
    protected $filters = [];

    /**
     * @var array
     */
    protected $shortCodes = [];

    /**
     *
     */
    public function run()
    {
        foreach ($this->filters as $hook) {
            add_filter($hook['hook'], array($hook['component'], $hook['callback']), $hook['priority'],
                $hook['accepted_args']);
        }

        foreach ($this->actions as $hook) {
            add_action($hook['hook'], array($hook['component'], $hook['callback']), $hook['priority'],
                $hook['accepted_args']);
        }

        foreach ($this->shortCodes as $shortCode) {
            if (!isset($shortCode['name']) || !isset($shortCode['source'])) {
                continue;
            }
            add_shortcode($shortCode['name'], [
                $shortCode['source'][0],
                $shortCode['source'][1]
            ]);
        }
    }

    /**
     * @param $hook
     * @param $component
     * @param $callback
     * @param int $priority
     * @param int $accepted_args
     */
    public function addAction(
        $hook,
        $component,
        $callback,
        $priority = 10,
        $accepted_args = 1
    ) {
        $this->actions = $this->add($this->actions, $hook, $component, $callback, $priority, $accepted_args);
    }

    /**
     * @param $hook
     * @param $component
     * @param $callback
     * @param int $priority
     * @param int $accepted_args
     */
    public function addFilter(
        $hook,
        $component,
        $callback,
        $priority = 10,
        $accepted_args = 1
    ) {
        $this->filters = $this->add($this->filters, $hook, $component, $callback, $priority, $accepted_args);
    }

    /**
     * @param string $name
     * @param array $source
     */
    public function addShortCode(string $name, array $source)
    {
        $shortCodes = [
            'name' => $name,
            'source' => $source
        ];
        $this->shortCodes[] = $shortCodes;
    }


    /**
     * @param $hooks
     * @param $hook
     * @param $component
     * @param $callback
     * @param $priority
     * @param $accepted_args
     * @return array
     */
    private
    function add(
        $hooks,
        $hook,
        $component,
        $callback,
        $priority,
        $accepted_args
    ) {

        $hooks[] = [
            'hook' => $hook,
            'component' => $component,
            'callback' => $callback,
            'priority' => $priority,
            'accepted_args' => $accepted_args
        ];

        return $hooks;

    }
}