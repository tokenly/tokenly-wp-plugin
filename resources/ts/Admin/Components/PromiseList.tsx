import * as React from 'react';
import { Component } from 'react';
import { PromiseData } from '../../Interfaces';

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
	sources: any;
}

interface PromiseListState {
	//
}

export class PromiseList extends Component<PromiseListProps, PromiseListState> {

	constructor( props: PromiseListProps ) {
		super( props );
		this.getPromiseSource = this.getPromiseSource.bind( this );
		this.sourceExists = this.sourceExists.bind( this );
	}

	onDetails( index: number ) {
		this.props.onDetails( index );
	}
	
	getPromiseSource( promiseItem: any ) {
		let address = promiseItem.source;
		const source = this.props.sources[ promiseItem.source ] ?? null;
		if ( source ) {
			address = source?.address_data?.label;
		}
		return address;
	}
	
	sourceExists( promiseItem: any ) {
		const source = this.props.sources[ promiseItem.source ] ?? null;
		if ( source ) {
			return true;
		} else {
			return false;
		}
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
									<div>
										<span>Source: </span>
										{ this.sourceExists( promiseItem )
											? <a href={`/wp-admin/admin.php?page=tokenpass-source-show&source=${promiseItem.source}`}>
												<strong>{ this.getPromiseSource( promiseItem ) }</strong>
											</a>
											: <span><strong>{ promiseItem.source }</strong></span>
										}
									</div>
									<div>
										<Flex gap={ 0 } align="center" justify="flex-start">
											<span>Participants: </span>
											<Dashicon icon="admin-users" />
											<strong><a href={`/tokenpass-user/${promiseItem?.promise_meta?.source_user?.id}`}>{ promiseItem?.promise_meta?.source_user?.name }</a></strong>
											<Dashicon style={ { margin: '0 5px' } } icon="arrow-right-alt" />
											<Dashicon icon="admin-users" />
											<strong><a href={`/tokenpass-user/${promiseItem?.promise_meta?.destination_user?.id}`}>{ promiseItem?.promise_meta?.destination_user?.name }</a></strong>
										</Flex>
									</div>
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
