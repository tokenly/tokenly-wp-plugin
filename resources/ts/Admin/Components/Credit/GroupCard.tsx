import * as React from 'react';
import GroupCardActions from './GroupCardActions';
import GroupInfo from './GroupInfo';
import GroupLink from './GroupLink';

import { 
	Card,
	CardHeader,
	CardBody,
	CardFooter
} from '@wordpress/components';

interface GroupCardProps {
	group: any;
}

export default function GroupCard( props: GroupCardProps ) {
	return (
		<Card size="extraSmall" style={ { width: '100%' } }>
			<CardHeader>
				<GroupLink name={ props.group?.name } uuid={ props.group?.uuid } />
			</CardHeader>
			<CardBody style={ { width: '100%' } }>
				<GroupInfo group={ props.group } />
			</CardBody>
			<CardFooter>
				<GroupCardActions group={ props.group?.uuid } />
			</CardFooter>
		</Card>
	);
}
 

