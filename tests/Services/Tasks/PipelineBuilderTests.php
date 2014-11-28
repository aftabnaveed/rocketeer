<?php
namespace Rocketeer\Services\Tasks;

use Rocketeer\TestCases\RocketeerTestCase;

class PipelineBuilderTests extends RocketeerTestCase
{
	public function testCanProperlyComputeDependenciesTree()
	{
		$pipeline = $this->queue->buildPipeline(array(
			'Rocketeer\Dummies\Tasks\RequiredParallelTask',
			'Rocketeer\Dummies\Tasks\ParallelTask',
			'Rocketeer\Dummies\Tasks\ParallelTask',
		));

		$this->assertEquals(['Rocketeer\Dummies\Tasks\RequiredParallelTask'], $pipeline[0]->queue);
		$this->assertEquals(array(
			'Rocketeer\Dummies\Tasks\ParallelTask',
			'Rocketeer\Dummies\Tasks\ParallelTask',
		), $pipeline[1]->queue);
	}

	public function testCanAutoResolveTaskDependencies()
	{
		$pipeline = $this->queue->buildPipeline(array(
			'Rocketeer\Dummies\Tasks\ParallelTask',
			'Rocketeer\Dummies\Tasks\ParallelTask',
		));

		$this->assertEquals(['Rocketeer\Dummies\Tasks\RequiredParallelTask'], $pipeline[0]->queue);
		$this->assertEquals(array(
			'Rocketeer\Dummies\Tasks\ParallelTask',
			'Rocketeer\Dummies\Tasks\ParallelTask',
		), $pipeline[1]->queue);
	}
}
