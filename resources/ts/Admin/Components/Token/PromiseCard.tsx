import * as React from 'react';
import { Component } from 'react';
import { resolve } from 'inversify-react';
import { TYPES } from '../../../Types';
import { PromiseData } from './../../../Interfaces';
import PromiseLink from './PromiseLink';
import PromiseInfo from './PromiseInfo';
import CardActions from './../CardActions';

import { 
	Card,
	CardHeader,
	CardBody,
	CardFooter,
	Flex,
} from '@wordpress/components';

interface PromiseCardProps {
	promise: PromiseData;
}

interface PromiseCardState {
	//
}

export default class PromiseCard extends Component<PromiseCardProps, PromiseCardState> {
	@resolve( TYPES.Variables.adminPageUrl )
	adminPageUrl: string;
	@resolve( TYPES.Variables.namespace )
	namespace: string;

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
						<PromiseLink id={ this.props.promise.promise_id } />
						{ this.props?.promise?.pseudo == true &&
							<span>
								<span className="tokenly-component-chip">pseudo</span>
							</span>
						}
					</Flex>
				</CardHeader>
				<CardBody style={ { width: '100%' } }>
					<PromiseInfo promise={ this.props.promise } />
				</CardBody>
				<CardFooter>
					<CardActions actions={
						[
							{
								title: 'View details',
								url: `${ this.adminPageUrl }${ this.namespace }-token-promise-show&promise=${this.props.promise.promise_id}`,
							},
							{
								title: 'Edit promise',
								url: `${ this.adminPageUrl }${ this.namespace }-token-promise-edit&promise=${ this.props.promise.promise_id }`,
							}
						]
					}
					/>
				</CardFooter>
			</Card>
		);
	}
}
 



