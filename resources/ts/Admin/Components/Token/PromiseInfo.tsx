import * as React from 'react';
import { Component } from 'react';
import PromiseParticipants from './PromiseParticipants';
import * as dayjs from 'dayjs'

import { 
	Flex,
} from '@wordpress/components';

interface AddressInfoProps {
	promise: any;
	verbose?: boolean;
}

interface AddressInfoState {
	//
}

export default class AddressInfo extends Component<AddressInfoProps, AddressInfoState> {

	constructor( props: AddressInfoProps ) {
		super( props );
		this.getProperties = this.getProperties.bind( this );
		this.isPromiseValid = this.isPromiseValid.bind( this );
		this.getListItems = this.getListItems.bind( this );
	}

	getListItems() {
		const properties = this.getProperties();
		return properties.map( ( property ) => {
			return (
				<div>
					<span>{ property.label }: </span>
					<span style={ { opacity: property.value ? 1 : 0.6 } }><strong>{ property.value ? property.value : '' }</strong></span>
				</div>
			);
		} );
	}

	getProperties() {
		const properties = [
			{
				label: 'Asset',
				value: this.props.promise?.asset,
			},
			{
				label: 'Quantity',
				value: this.props.promise?.quantity?.value_sat,
			},
		];
		if ( this.props.verbose ) {
			properties.push(
				{
					label: 'Ref',
					value: this.props.promise?.ref,
				},
				{
					label: 'Note',
					value: this.props.promise?.note,
				},
				{
					label: 'Created at',
					value: this.dateFormatted( this.props.promise?.created_at ),
				},
				{
					label: 'Updated at',
					value: this.dateFormatted( this.props.promise?.updated_at ),
				},
			)
		}
		return properties;
	}

	isPromiseValid() {
		return ( this.props.promise && typeof this.props.promise === 'object' );
	}

	dateFormatted( date: Date ) {
		if ( date ) {
			return dayjs( date ).format( 'MMMM D, YYYY h:mm A' )
		}
		return;
	}

	render() {
		return (
			<Flex>
				<Flex style={ { width: '100%', alignItems: 'center' } }>
					<div style={ { flex: 1 } }>
						<div>
							<span>Source: </span>
							<a href={`/wp-admin/admin.php?page=tokenly-token-source-show&source=${this.props.promise?.source_id}`}>
								<strong>{this.props.promise?.source?.address.label}</strong>
							</a>
						</div>
						<PromiseParticipants promise={ this.props.promise } />
						{ this.getListItems() }
					</div>
				</Flex>
			</Flex>
		);
	}
}
