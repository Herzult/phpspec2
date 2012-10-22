<?php

namespace spec\PHPSpec2\Initializer;

use PHPSpec2\ObjectBehavior;

class ArgumentsProphetsInitializer extends ObjectBehavior
{
    /**
     * @param PHPSpec2\SpecificationInterface               $specification
     * @param PHPSpec2\Loader\Node\Example                  $example
     * @param PHPSpec2\Initializer\FunctionParametersReader $parametersReader
     * @param PHPSpec2\Mocker\MockerInterface               $mocker
     * @param PHPSpec2\Wrapper\ArgumentsUnwrapper           $unwrapper
     */
    function let($specification, $example, $parametersReader, $mocker, $unwrapper)
    {
        $this->beConstructedWith($parametersReader, $mocker, $unwrapper);
    }

    function it_should_implement_InitializerInterface()
    {
        $this->shouldBeAnInstanceOf('PHPSpec2\Initializer\InitializerInterface');
    }

    function it_should_support_any_specification($specification, $example)
    {
        $this->supports($specification, $example)->shouldReturn(true);
    }

    /**
     * @param PHPSpec2\Prophet\ProphetsCollection $prophets
     * @param PHPSpec2\Matcher\MatchersCollection $matchers
     */
    function it_should_set_prophets_for_example_arguments($specification, $example, $prophets,
                                                          $matchers, $parametersReader, $mocker)
    {
        $parametersReader->getParameters($example)->willReturn(array(
            'param1' => 'stdClass',
            'param2' => null
        ))->shouldBeCalled();

        $mocker->mock('stdClass')->shouldBeCalled();
        $mocker->mock(null)->shouldNotBeCalled();

        $prophets->setCollaborator('param1', ANY_ARGUMENT)->shouldBeCalled();
        $prophets->setCollaborator('param2', ANY_ARGUMENT)->shouldBeCalled();

        $this->initialize($specification, $example, $prophets, $matchers);
    }
}
