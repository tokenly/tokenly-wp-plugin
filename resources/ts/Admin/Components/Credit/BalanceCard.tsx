import * as React from 'react';
import { Component } from 'react';
import { useInjection } from 'inversify-react';
import { TYPES } from '../../../Types';
import CardActions from './../CardActions';
import GroupLink from './GroupLink';

import { 
	Card,
	CardHeader,
	CardBody,
	Flex,
	Button,
	CardFooter
} from '@wordpress/components';

interface BalanceCardProps {
	balance: any;
}

export default function BalanceCard( props: BalanceCardProps ) {
	const adminPageUrl = useInjection( TYPES.Variables.adminPageUrl );
	const namespace = useInjection( TYPES.Variables.namespace );

	return (
		<Card size="extraSmall" style={ { width: '100%' } }>
			<CardHeader>
				<GroupLink 
					uuid={ props.balance.group_id }
					name={ props.balance?.group?.name }
					text={ ( !props.balance?.group ) }
				/>
			</CardHeader>
			<CardBody style={ { width: '100%' } }>
				<Flex
					//@ts-ignore
					direction="column"
				>
					<div>Balance: <b>{ props.balance?.balance }</b></div>
				</Flex>
			</CardBody>
			<CardFooter>
				<CardActions
					actions={
						[
							{
								title: 'Debit',
								url: `${ adminPageUrl }${ namespace }-credit-transaction-store&group=${ props.balance.group_id }&type=debit`,
							},
							{
								title: 'Credit',
								url: `${ adminPageUrl }${ namespace }-credit-transaction-store&group=${ props.balance.group_id }&type=credit`,
							},
							{
								title: 'View Group',
								url: `${ adminPageUrl }${ namespace }-credit-group-show&group=${ props.balance.group_id }`,
							},
						]
					}
				/>
			</CardFooter>
		</Card>
	);
}
 

