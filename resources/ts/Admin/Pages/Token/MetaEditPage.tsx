import { resolve } from 'inversify-react';
import * as React from 'react';
import { Component } from 'react';
import MetaRepositoryInterface from '../../../Interfaces/Repositories/Token/MetaRepositoryInterface';
import { TokenMetaData } from '../../../Interfaces';
import { TYPES } from '../../../Types';
import MetaEditForm from '../../Components/Token/MetaEditForm';
import eventBus from './../../../EventBus';

import { 
	PanelRow,
} from '@wordpress/components';

import { 
	Fragment,
} from '@wordpress/element';

interface MetaEditPageData {
	meta: TokenMetaData;
	extra: any;
}

interface MetaEditPageProps {
	pageData: MetaEditPageData;
}

interface MetaEditPageState {
	id: number;
	editData: any;
}

export default class MetaEditPage extends Component<MetaEditPageProps, MetaEditPageState> {
	@resolve( TYPES.Repositories.Token.MetaRepositoryInterface )
	metaRepository: MetaRepositoryInterface;

	state: MetaEditPageState = {
		id: null,
		editData: {
			asset: '',
			extra: [],
		},
	}
	
	constructor( props: MetaEditPageProps ) {
		super( props );
		const urlParams = new URLSearchParams(window.location.search);
		this.state.id = parseInt( urlParams.get( 'post' ) );
		let extra = Object.assign( [], this.props.pageData.meta?.extra );
		if ( extra && Array.isArray( extra ) ) {
			extra = extra.filter( function ( item: any ) {
				return item != null;
			} );
		} else {
			extra = [];
		}
		const asset = this.props.pageData.meta?.asset ?? '';
		this.state.editData = {
			asset: asset,
			extra: extra,
		}
		this.onEditDataChange = this.onEditDataChange.bind( this );
	}

	onEditDataChange( newData: any ) {
		newData.extra = newData.extra.filter( function ( item: any ) {
			return item != null;
		} );
		this.setState( {
			editData: newData,
		} );
		eventBus.dispatch( 'postDataUpdated', newData );
	}

	render() {
		return (
			<Fragment>
				<PanelRow>
					<MetaEditForm
						editData={ this.state.editData }
						onChange={ this.onEditDataChange }
					/>
				</PanelRow>
			</Fragment>
		);
	}
}
