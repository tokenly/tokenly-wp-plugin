import * as React from 'react';

import { 
	Flex,
	Button,
} from '@wordpress/components';

interface CardActionsProps {
	actions: Array<any>;
}

export default function CardActions( props: CardActionsProps ) {
	const listItems = props.actions.map( ( action: any ) => {
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
