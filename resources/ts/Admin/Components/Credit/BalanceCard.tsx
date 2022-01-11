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
					<span>{ this.props.balance?.group }</span>
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
					</Flex>
				</CardFooter>
			</Card>
		);
	}
}
 

