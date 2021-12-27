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

interface GroupCardProps {
	group: any;
}

interface GroupCardState {
	//
}

export default class GroupCard extends Component<GroupCardProps, GroupCardState> {

	constructor( props: GroupCardProps ) {
		super( props );
	}

	render() {
		return (
			<Card size="extraSmall" style={ { width: '100%' } }>
				<CardHeader>
					<div>{ this.props.group.name }</div>
				</CardHeader>
				<CardBody style={ { width: '100%' } }>
					<Flex style={ { width: '100%', alignItems: 'center' } }>
						<div style={ { flex: 1 } }>
							<div><span>Active: </span><strong>{ this.props.group.active ? 'Yes' : 'No' }</strong></div>
						</div>
					</Flex>
				</CardBody>
				<CardFooter>
					<Flex justify="flex-start">
						<Button
							isSecondary
							isSmall
							href={ `/wp-admin/admin.php?page=tokenly-credit-transaction-index&group=${ this.props.group.uuid }` }
						>
							View transactions
						</Button>
						<Button
							isSecondary
							isSmall
							href={ `/wp-admin/admin.php?page=tokenly-credit-group-show&group=${ this.props.group.uuid }` }
						>
							View details
						</Button>
						<Button
							isSecondary
							isSmall
							href={ `/wp-admin/admin.php?page=tokenly-credit-group-edit&group=${ this.props.group.uuid }` }
						>
							Edit group
						</Button>
					</Flex>
				</CardFooter>
			</Card>
		);
	}
}
 

