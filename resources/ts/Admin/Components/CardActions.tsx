import * as React from 'react';
import { Component } from 'react';

import { 
	Flex,
	Button,
} from '@wordpress/components';

interface CardActionsProps {
	actions: Array<any>;
}

interface CardActionsState {
	//
}

export default class CardActions extends Component<CardActionsProps, CardActionsState> {

	constructor( props: CardActionsProps ) {
		super( props );
	}

	render() {
		const listItems = this.props.actions.map( ( action: any ) => {
			return (
				<Button
					isSecondary
					isSmall
					href={ action.url }
				>
					{ action.title }
				</Button>
			)
		} )
		return (
			<Flex justify="flex-start">{ listItems }</Flex>
		);
	}
}
 

