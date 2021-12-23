import * as React from 'react';
import { Component } from 'react';
import { PromiseData } from '../../Interfaces';
import { PromiseSourceInfo } from './PromiseSourceInfo';
import { PromiseParticipants } from './PromiseParticipants';

import { 
	Button,
	Card,
	CardHeader,
	CardBody,
	CardFooter,
	Flex,
	Dashicon
} from '@wordpress/components';

interface PromiseCardProps {
	promise: PromiseData;
	sources: any;
}

interface PromiseCardState {
	//
}

export class PromiseCard extends Component<PromiseCardProps, PromiseCardState> {

	constructor( props: PromiseCardProps ) {
		super( props );
	}

	render() {
		return (
			<Card size="extraSmall" style={ { width: '100%' } }>
				<CardHeader>
					<Flex
						align="center"
						justify="flex-start"
					>
						<span>
							<span>№ </span>
							<strong>
								<a href={ `/wp-admin/admin.php?page=tokenly-token-promise-show&promise=${this.props.promise.promise_id}` }>
									{ this.props.promise.promise_id }
								</a>
							</strong>
						</span>
						{ this.props?.promise?.pseudo == true &&
							<span>
								<span className="tokenly-component-chip">pseudo</span>
							</span>
						}
					</Flex>
				</CardHeader>
				<CardBody style={ { width: '100%' } }>
					<Flex style={ { width: '100%', alignItems: 'center' } }>
						<div style={ { flex: 1 } }>
							<PromiseSourceInfo promise={ this.props.promise } sources={ this.props.sources } />
							<PromiseParticipants promise={ this.props.promise } />
							<div><span>Asset: </span><strong>{ this.props.promise.asset }</strong></div>
							<div><span>Quantity: </span><strong>{ this.props.promise?.quantity?.value }</strong></div>
						</div>
					</Flex>
				</CardBody>
				<CardFooter>
					<Flex justify="flex-start">
						<Button
							isSecondary
							isSmall
							href={ `/wp-admin/admin.php?page=tokenly-token-promise-show&promise=${this.props.promise.promise_id}` }
						>
							Details
						</Button>
						<Button
							isSecondary
							isSmall
							href={ `/wp-admin/admin.php?page=tokenly-token-promise-edit&promise=${ this.props.promise.promise_id }` }
						>
							Manage promise
						</Button>
					</Flex>
				</CardFooter>
			</Card>
		);
	}
}
 



