import * as React from 'react';
import { Component } from 'react';
import { useInjection } from 'inversify-react';
import { TYPES } from '../../../Types';
import CardActions from './../CardActions';
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
	const adminPageUrl = useInjection( TYPES.Variables.adminPageUrl );
	const namespace = useInjection( TYPES.Variables.namespace );

	return (
		<Card size="extraSmall" style={ { width: '100%' } }>
			<CardHeader>
				<GroupLink name={ props.group?.name } uuid={ props.group?.uuid } />
			</CardHeader>
			<CardBody style={ { width: '100%' } }>
				<GroupInfo group={ props.group } />
			</CardBody>
			<CardFooter>
				<CardActions
					actions={
						[
							{
								title: 'View Transactions',
								url: `${ adminPageUrl }${ namespace }-credit-transaction-index&group=${ props.group.uuid }`,
							},
							{
								title: 'View Details',
								url: `${ adminPageUrl }${ namespace }-credit-group-show&group=${ props.group.uuid }`,
							},
							{
								title: 'Edit Group',
								url: `${ adminPageUrl }${ namespace }-credit-group-edit&group=${ props.group.uuid }`,
							},
						]
					}
				/>
			</CardFooter>
		</Card>
	);
}
 

