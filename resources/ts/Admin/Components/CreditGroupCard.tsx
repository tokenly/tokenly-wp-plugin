import * as React from 'react';
import { Component } from 'react';

import { 
	Button,
	Card,
	CardHeader,
	CardBody,
	Flex,
	CardFooter
} from '@wordpress/components';

interface CreditGroupCardProps {
	creditGroup: any;
}

interface CreditGroupCardState {
	//
}

export class CreditGroupCard extends Component<CreditGroupCardProps, CreditGroupCardState> {

	constructor( props: CreditGroupCardProps ) {
		super( props );
	}

	render() {
		return (
			<Card size="extraSmall" style={ { width: '100%' } }>
				<CardHeader>
					<div>{ this.props.creditGroup.name }</div>
				</CardHeader>
				<CardBody style={ { width: '100%' } }>
					<Flex style={ { width: '100%', alignItems: 'center' } }>
						<div style={ { flex: 1 } }>
							<div><span>Active: </span><strong>{ this.props.creditGroup.active ? 'Yes' : 'No' }</strong></div>
						</div>
					</Flex>
				</CardBody>
				<CardFooter>
					<Flex justify="flex-start">
						<Button
							isSecondary
							isSmall
							href={ `/wp-admin/admin.php?page=tokenly-credit-transaction-index&credit_group=${ this.props.creditGroup.uuid }` }
						>
							View transactions
						</Button>
						<Button
							isSecondary
							isSmall
							href={ `/wp-admin/admin.php?page=tokenly-credit-group-show&credit_group=${ this.props.creditGroup.uuid }` }
						>
							View details
						</Button>
						<Button
							isSecondary
							isSmall
							href={ `/wp-admin/admin.php?page=tokenly-credit-group-edit&credit_group=${ this.props.creditGroup.uuid }` }
						>
							Manage group
						</Button>
					</Flex>
				</CardFooter>
			</Card>
		);
	}
}
 

