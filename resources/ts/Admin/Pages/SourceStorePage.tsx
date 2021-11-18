import { resolve } from 'inversify-react';
import * as React from 'react';
import Page from './Page';
import { Component } from 'react';
import { SourceRepositoryInterface } from '../../Interfaces/Repositories/SourceRepositoryInterface';
import { SourceStoreForm } from '../Components/SourceStoreForm';
import { SourceData } from '../../Interfaces';
import { TYPES } from '../../Types';

declare const window: any;

import { 
	Panel,
	PanelBody,
	PanelRow,
} from '@wordpress/components';

interface SourceIndexPageData {
	addresses: Array<any>;
}

interface SourceIndexPageProps {
	pageData: SourceIndexPageData;
	saving: boolean;
}

interface SourceIndexPageState {
	storingSource: boolean;
}

export default class SourceIndexPage extends Component<SourceIndexPageProps, SourceIndexPageState> {
	@resolve( TYPES.SourceRepositoryInterface )
	sourceRepository: SourceRepositoryInterface;
	
	state: SourceIndexPageState = {
		storingSource: false,
	}
	constructor( props: SourceIndexPageProps ) {
		super( props );
		console.log(this.props.pageData);
		this.onSubmit = this.onSubmit.bind( this );
	}

	return() {
		window.location = '/wp-admin/admin.php?page=tokenpass-source-index';
	}
	
	onSubmit( promise: SourceData ) {
		this.sourceRepository.store( promise ).then( ( result: any ) => {
			this.return();
		});
	}
	
	render() {
		return (
			<Page title={'Register source address'}>
				<div style={ { marginBottom: '8px' } }>
					<a href='/wp-admin/admin.php?page=tokenpass-source-index'>Back to source address list</a>
				</div>
				<Panel>
					<PanelBody>
						<PanelRow>
							<SourceStoreForm
								onSubmit={ this.onSubmit }
								onCancel={ this.return }
								saving={ this.state.storingSource }
								style={ { marginBottom: '12px' } }
								addresses={ this.props.pageData.addresses }
							/>
						</PanelRow>
					</PanelBody>
				</Panel>
			</Page>
		);
	}
}
