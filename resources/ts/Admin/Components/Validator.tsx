import * as React from 'react';
import { Component } from 'react';

import { 
	Flex,
	Button,
} from '@wordpress/components';

interface ValidatorProps {
	value: any;
	onChange?: any;
	rules?: Array<string>;
}

interface ValidatorState {
	errors: any;
}

export default class Validator extends Component<ValidatorProps, ValidatorState> {
	state: ValidatorState = {
		errors: [],
	}
	
	constructor( props: ValidatorProps ) {
		super( props );
	}
	
	render() {
		return (
			<Flex
				//@ts-ignore
				direction="column"
			>
				
			</Flex>
		);
	}
}
 

