import * as React from 'react';
import { useInjection } from 'inversify-react';
import { TYPES } from '../../Types';
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
	username?: string;
}

export default function BalanceCard( props: BalanceCardProps ) {
	const adminPageUrl = useInjection( TYPES.Variables.adminPageUrl );
	const namespace = useInjection( TYPES.Variables.namespace );

	function getDebitLink(): string {
		let link = `${ adminPageUrl }${ namespace }-credit-transaction-store&group=${ props.balance.group_id }&type=debit`;
		if ( props.username ) {
			link = `${link}&account=${props.username}`;
		}
		return link;
	}

	function getCreditLink(): string {
		let link = `${ adminPageUrl }${ namespace }-credit-transaction-store&group=${ props.balance.group_id }&type=credit`;
		if ( props.username ) {
			link = `${link}&account=${props.username}`;
		}
		return link;
	}

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
								href: getDebitLink(),
							},
							{
								title: 'Credit',
								href: getCreditLink(),
							},
							{
								title: 'View Group',
								href: `${ adminPageUrl }${ namespace }-credit-group-show&id=${ props.balance.group_id }`,
							},
						]
					}
				/>
			</CardFooter>
		</Card>
	);
}
 

