import * as React from 'react';
import { useInjection } from 'inversify-react';
import { TYPES } from '../../Types';

import { 
	Flex,
	Button,
} from '@wordpress/components';

interface GroupShowActionsProps {
	group: string;
}

export default function GroupShowActions( props: GroupShowActionsProps ) {
	const adminPageUrl = useInjection( TYPES.Variables.adminPageUrl );
	const namespace = useInjection( TYPES.Variables.namespace );

	return (
		<Flex justify="flex-start" align="center" >
			<Button
				isSecondary
				isLarge
				href={ `${ adminPageUrl }${ namespace }-credit-transaction-index&group=${ props.group }` }
			>
				View Transactions
			</Button>
			<Button
				isSecondary
				isLarge
				href={ `${ adminPageUrl }${ namespace }-credit-group-account-index&id=${ props.group }` }
			>
				View Accounts
			</Button>
			<Button
				isSecondary
				isLarge
				href={ `${adminPageUrl}${namespace}-credit-group-edit&id=${ props.group }` }
			>
				Manage Group
			</Button>
		</Flex>
	);
}
 

