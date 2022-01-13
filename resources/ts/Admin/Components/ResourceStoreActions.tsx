import * as React from 'react';
import { Component } from 'react';

import { 
	Flex,
	Button,
	Spinner,
} from '@wordpress/components';

interface ResourceEditActionsProps {
	storing: boolean;
	loading?: boolean;
	onStore: any;
	onCancel: any;
	name: string;
	disableStore?: boolean;
}

export default function ResourceEditActions( props: ResourceEditActionsProps ) {
	return (
		<Flex justify="flex-start" align="center" >
			<Button
				isPrimary
				isBusy={ props.storing }
				onClick={ props.onStore }
			>
				{ `Create ${props.name}` }
			</Button>
			<Button
				isTertiary
				onClick={ props.onCancel }
			>
				Cancel
			</Button>
		</Flex>
	);
}
 

