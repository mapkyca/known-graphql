<?php

namespace IdnoPlugins\GraphQL\Pages {

    use GraphQL\Type\Definition\ObjectType;
    use GraphQL\Type\Definition\Type;
    use GraphQL\Type\Schema;
    use GraphQL\GraphQL;

    class Endpoint extends \Idno\Common\Page {

	public function getContent() {
	    try {
		$queryType = new ObjectType([
		    'name' => 'Query',
		    'fields' => [
			'echo' => [
			    'type' => Type::string(),
			    'args' => [
				'message' => ['type' => Type::string()],
			    ],
			    'resolve' => function ($rootValue, $args) {
				return $rootValue['prefix'] . $args['message'];
			    }
			],
		    ],
		]);
		$mutationType = new ObjectType([
		    'name' => 'Calc',
		    'fields' => [
			'sum' => [
			    'type' => Type::int(),
			    'args' => [
				'x' => ['type' => Type::int()],
				'y' => ['type' => Type::int()],
			    ],
			    'resolve' => function ($calc, $args) {
				return $args['x'] + $args['y'];
			    },
			],
		    ],
		]);
			    
		// See docs on schema options:
		// http://webonyx.github.io/graphql-php/type-system/schema/#configuration-options
		$schema = new Schema([
		    'query' => $queryType,
		    'mutation' => $mutationType,
		]);
		
		/*$rawInput = file_get_contents('php://input');
		$input = json_decode($rawInput, true);
		$query = $input['query'];
		$variableValues = isset($input['variables']) ? $input['variables'] : null;
		$rootValue = ['prefix' => 'You said: '];
		$result = GraphQL::executeQuery($schema, $query, $rootValue, null, $variableValues);
		$output = $result->toArray();*/
                
                
		$query = $this->getInput('query');
		$variableValues = $this->getInput('variables');
                
		$rootValue = ['prefix' => 'You said: '];
                
		$result = GraphQL::executeQuery($schema, $query, $rootValue, null, $variableValues);
		$output = $result->toArray();
	    } catch (\Exception $e) {
		$output = [
		    'error' => [
			'message' => $e->getMessage()
		    ]
		];
	    }
            
	    header('Content-Type: application/json; charset=UTF-8');
            
	    echo json_encode($output, JSON_PRETTY_PRINT);
	}

	function post()
        {
            \Idno\Core\Idno::site()->session()->publicGatekeeper();

            \Idno\Core\Idno::site()->template()->autodetectTemplateType();
            
            $this->parseJSONPayload();

            $arguments = func_get_args();
            if (!empty($arguments)) $this->arguments = $arguments;

            \Idno\Core\Idno::site()->events()->triggerEvent('page/head', array('page' => $this));
            \Idno\Core\Idno::site()->events()->triggerEvent('page/post', array('page_class' => get_called_class(), 'arguments' => $arguments));


	    return $this->getContent();
        }

    }

}