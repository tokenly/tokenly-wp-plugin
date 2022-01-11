import * as React from 'react';
import { Component } from 'react';

import { 
	Flex,
	Button,
} from '@wordpress/components';

interface BackButtonProps {
	//
}

interface BackButtonState {
	//
}

export default class BackButton extends Component<BackButtonProps, BackButtonState> {

	constructor( props: BackButtonProps ) {
		super( props );
	}

	onClick() {
		history.back();
	}

	render() {
		return (
			<Flex justify="flex-start">
				<Button isTertiary icon="arrow-left-alt" onClick={ this.onClick }>Go Back</Button>
			</Flex>
		);
	}
}
 

