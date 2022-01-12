import * as React from 'react';
import { Component } from 'react';
import { SourceItem } from '../../../Interfaces';
import { resolve } from 'inversify-react';
import { TYPES } from '../../../Types';
import CardActions from './../CardActions';

import { 
	Button,
	Card,
	CardHeader,
	CardBody,
	Flex,
	CardFooter
} from '@wordpress/components';

interface SourceCardProps {
	source: SourceItem;
}

interface SourceCardState {
	//
}

export default class SourceCard extends Component<SourceCardProps, SourceCardState> {
	@resolve( TYPES.Variables.adminPageUrl )
	adminPageUrl: string;
	@resolve( TYPES.Variables.namespace )
	namespace: string;

	constructor( props: SourceCardProps ) {
		super( props );
		this.getAssets = this.getAssets.bind( this );
	}
	
	getAssets() {
		let assets = 'all';
		if ( this.props.source?.assets?.length ) {
			assets = this.props.source?.assets?.join( ', ' );
		}
		return assets;
	}

	render() {
		return (
			<Card size="extraSmall" style={ { width: '100%' } }>
				<CardHeader>
					<div title={ this.props.source.address_id }>
						<b>
							<a 
								href={ `${this.adminPageUrl}${this.namespace}-token-source-show&source=${ this.props.source.address_id }` }
							>
								{ this.props.source.address?.label }
							</a>
						</b>
					</div>
				</CardHeader>
				<CardBody style={ { width: '100%' } }>
					<Flex style={ { width: '100%', alignItems: 'center' } }>
						<div style={ { flex: 1 } }>
							<div><span>Whitelisted Assets: </span><b>{ this.getAssets() }</b></div>
						</div>
					</Flex>
				</CardBody>
				<CardFooter>
					<CardActions actions={
						[
							{
								title: 'View Details',
								url: `${ this.adminPageUrl }${ this.namespace }-token-source-show&source=${ this.props.source.address_id }`,
							},
							{
								title: 'View Balance',
								url: `${ this.adminPageUrl }${ this.namespace }-token-address-balance-index&id=${ this.props.source.address_id }`,
							},
							{
								title: 'Edit Source',
								url: `${ this.adminPageUrl }${ this.namespace }-token-source-edit&source=${ this.props.source.address_id }`,
							}
						]
					}
					/>
				</CardFooter>
			</Card>
		);
	}
}
 

