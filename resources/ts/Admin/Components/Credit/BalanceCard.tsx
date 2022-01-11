import * as React from 'react';
import { Component } from 'react';
import { resolve } from 'inversify-react';
import { TYPES } from '../../../Types';
import CardActions from './../CardActions';
import GroupInfo from './GroupInfo';
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

interface BalanceCardState {
	//
}

export default class BalanceCard extends Component<BalanceCardProps, BalanceCardState> {
	@resolve( TYPES.Variables.adminPageUrl )
	adminPageUrl: string;
	@resolve( TYPES.Variables.namespace )
	namespace: string;

	constructor( props: BalanceCardProps ) {
		super( props );
	}

	render() {
		return (
			<Card size="extraSmall" style={ { width: '100%' } }>
				<CardHeader>
					<GroupLink 
						uuid={ this.props.balance.group_id }
						name={ this.props.balance?.group?.name }
						text={ ( !this.props.balance?.group ) }
					/>
				</CardHeader>
				<CardBody style={ { width: '100%' } }>
					<Flex
						//@ts-ignore
						direction="column"
					>
						<div>Balance: <strong>{ this.props.balance?.balance }</strong></div>
					</Flex>
				</CardBody>
				<CardFooter>
					<Flex
						justify="flex-start"
					>
						<Button
							isSecondary
							isSmall
						>
							Debit
						</Button>
						<Button
							isSecondary
							isSmall
						>
							Credit
						</Button>
						<Button
							isSecondary
							isSmall
						>
							View group
						</Button>
					</Flex>
				</CardFooter>
			</Card>
		);
	}
}
 

