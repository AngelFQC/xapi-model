<?php

namespace spec\Xabbuh\XApi\Model\Interaction;

use Xabbuh\XApi\Model\Interaction\InteractionComponent;
use Xabbuh\XApi\Model\Interaction\PerformanceInteractionDefinition;

class PerformanceInteractionDefinitionSpec extends InteractionDefinitionSpec
{
    public function it_returns_a_new_instance_with_steps()
    {
        $steps = array(new InteractionComponent('test'));
        $interaction = $this->withSteps($steps);

        $this->getSteps()->shouldBeNull();

        $interaction->shouldNotBe($this);
        $interaction->shouldBeAnInstanceOf('\Xabbuh\XApi\Model\Interaction\PerformanceInteractionDefinition');
        $interaction->getSteps()->shouldReturn($steps);
    }

    function it_is_not_equal_if_only_other_interaction_has_steps()
    {
        $interaction = $this->createEmptyInteraction();
        $interaction = $interaction->withSteps(array(new InteractionComponent('test')));

        $this->equals($interaction)->shouldReturn(false);
    }

    function it_is_not_equal_if_only_this_interaction_has_steps()
    {
        $this->beConstructedWith(null, null, null, null, null, array(new InteractionComponent('test')));

        $this->equals($this->createEmptyInteraction())->shouldReturn(false);
    }

    function it_is_not_equal_if_number_of_steps_differs()
    {
        $this->beConstructedWith(null, null, null, null, null, array(new InteractionComponent('test')));

        $interaction = $this->createEmptyInteraction();
        $interaction = $interaction->withSteps(array(new InteractionComponent('test'), new InteractionComponent('foo')));

        $this->equals($interaction)->shouldReturn(false);
    }

    function it_is_not_equal_if_steps_differ()
    {
        $this->beConstructedWith(null, null, null, null, null, array(new InteractionComponent('foo')));

        $interaction = $this->createEmptyInteraction();
        $interaction = $interaction->withSteps(array(new InteractionComponent('bar')));

        $this->equals($interaction)->shouldReturn(false);
    }

    function it_is_equal_if_steps_are_equal()
    {
        $this->beConstructedWith(null, null, null, null, null, array(new InteractionComponent('test')));

        $interaction = $this->createEmptyInteraction();
        $interaction = $interaction->withSteps(array(new InteractionComponent('test')));

        $this->equals($interaction)->shouldReturn(true);
    }

    protected function createEmptyInteraction()
    {
        return new PerformanceInteractionDefinition();
    }
}
