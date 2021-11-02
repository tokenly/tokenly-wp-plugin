import * as React from 'react';
import { Component } from 'react';
import { PromiseData } from '../../interfaces';

import { 
	Button,
	Flex,
	Dashicon,
	Card,
	CardBody,
	CardHeader,
	CardFooter,
} from '@wordpress/components';

interface PromiseListProps {
	promises: Array<PromiseData>;
	onDetails: any;
}

interface PromiseListState {
	//
}

export class PromiseList extends Component<PromiseListProps, PromiseListState> {

	constructor( props: PromiseListProps ) {
		super( props );
	}

	onDetails( index: number ) {
		this.props.onDetails( index );
	}

	render() {
		let listItems = Object.keys( this.props.promises ).map( ( key: any ) => this.props.promises[ key ] ) as any;
		listItems = listItems.map( ( promiseItem: PromiseData, i: number ) => {
			return (
				<div style={ { width: '100%' } }>
					<Card size="extraSmall" style={ { width: '100%' } }>
						<CardHeader>
							<div><strong>№ { promiseItem.promise_id }</strong></div>
						</CardHeader>
						<CardBody style={ { width: '100%' } }>
							<Flex style={ { width: '100%', alignItems: 'center' } }>
								<div style={ { flex: 1 } }>
									<div><span>Source: </span><span><strong>{ promiseItem.source }</strong></span></div>
									<div><span>Destination: </span><strong>{ promiseItem.destination }</strong></div>
									<div><span>Asset: </span><strong>{ promiseItem.asset }</strong></div>
									<div><span>Quantity: </span><strong>{ promiseItem.quantity }</strong></div>
								</div>
							</Flex>
						</CardBody>
						<CardFooter>
							<Flex justify="flex-start">
								<Button
									isSecondary
									isSmall
									onClick={() => {
										this.onDetails( i );
									}}
								>
									Details
								</Button>
								<Button
									isSecondary
									isSmall
									href={ `/wp-admin/admin.php?page=tokenpass-promise-edit&promise=${ promiseItem.promise_id }` }
								>
									Manage promise
								</Button>
							</Flex>
						</CardFooter>
					</Card>
				</div>
			);
		}
		);
		return (
			// @ts-ignore
			<Flex style={ { width: '100%' } } direction="column">{ listItems }</Flex> 
		);
	}
}
