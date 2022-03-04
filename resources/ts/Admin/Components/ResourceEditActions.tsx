import * as React from 'react';

import { 
	Flex,
	Button,
} from '@wordpress/components';

interface ResourceEditActionsProps {
	saving: boolean;
	deleting?: boolean;
	onSave?: any;
	onDelete?: any;
	onCancel: any;
	name: string;
	noDelete?: boolean;
}

export default function ResourceEditActions( props: ResourceEditActionsProps ) {
	return (
		<Flex justify="flex-start" align="center" >
			<Button
				isPrimary
				isBusy={ props.saving }
				onClick={ props.onSave }
				type="submit"
			>
				{ `Save ${props.name}` }
			</Button>
		{ !props.noDelete &&
			<Button
				isDestructive
				isSecondary
				isBusy={ props.deleting }
				onClick={ props.onDelete }
			>
				{ `Delete ${props.name}` }
			</Button>
		}
			<Button
				isTertiary
				onClick={ () => {
					history.back();
				} }
			>
				Cancel
			</Button>
		</Flex>
	);
}
 

